<?php
public function run() {
    // Allow execution to continue even if the request gets canceled.
    @ignore_user_abort(TRUE);

    // Try to allocate enough time to run all the hook_cron implementations.
    drupal_set_time_limit(240);
    return $this->processQueues();
}
// очереди процессов
protected function processQueues() {

    // Prevent session information from being saved while cron is running.
    $original_session_saving = drupal_save_session();
    drupal_save_session(FALSE);

    // Force the current user to anonymous to ensure consistent permissions on
    $original_user = $GLOBALS['user'];
    $GLOBALS['user'] = drupal_anonymous_user();

    $return = FALSE;

    // Try to acquire cron lock.
    if (!lock_acquire('cron', 240.0)) {
        // Cron is still running normally.
        return watchdog('cron', 'Attempting to re-run cron while it is already running.', array(), WATCHDOG_WARNING);
    }



    $queues = module_invoke_all('cron_queue_info');
    drupal_alter('cron_queue_info', $queues);



//Grab the defined cron queues.
    //Захват определенной очереди хрон.
//    $array = array(
//        1    => "a",
////        "1"  => "b",
//        1.5  => "c",
//
//    );

    $queues = module_invoke_all('cron_queue_info');
    drupal_alter('cron_queue_info', $queues);

// Make sure every queue exists. There is no harm in trying to recreate an
// existing queue.
foreach ($queues as $queue_name => $info) {
    DrupalQueue::get($queue_name)->createQueue();
}
// Iterate through the modules calling their cron handlers (if any):
foreach (module_implements('cron') as $module) {
    // Do not let an exception thrown by one module disturb another.
    try {
        module_invoke($module, 'cron');
    }
    catch (Exception $e) {
        watchdog_exception('cron', $e);
    }
}


    // Make sure every queue exists. There is no harm in trying to recreate an
    // existing queue.
// Убедиться, что каждая очередь существует. Нет никакого вреда в попытке воссоздать
// существующей очереди.


    foreach ($queues as $queue_name => $info) {
        DrupalQueue::get($queue_name)->createQueue();
    }
    // Iterate through the modules calling their cron handlers (if any):
// Перебираем модулей вызова их обработчиков хрон (если таковые имеются):
    foreach (module_implements('cron') as $module) {
        // Do not let an exception thrown by one module disturb another.
        // Не дай исключения, один модуль мешала другим.
        try {
            module_invoke($module, 'cron');
        }
        catch (Exception $e) {
            watchdog_exception('cron', $e);
        }
    }

    // Record cron time.
    variable_set('cron_last', REQUEST_TIME);
    watchdog('cron', 'Cron run completed.', array(), WATCHDOG_NOTICE);
    // Release cron lock.
    lock_release('cron');
    // Return TRUE so other functions can check if it did run successfully
    $return = TRUE;


    foreach ($queues as $queue_name => $info) {
        if (!empty($info['skip on cron'])) {
            // Do not run if queue wants to skip.
            continue;
        }


        $callback = $info['worker callback'];
        $end = time() + (isset($info['time']) ? $info['time'] : 15);
        $queue = DrupalQueue::get($queue_name);

        while (time() < $end && ($item = $queue->claimItem())) {
            try {
                call_user_func($callback, $item->data);
                $queue->deleteItem($item);
            }
            catch (Exception $e) {
                // In case of exception log it and leave the item in the queue
                // to be processed again later.
                watchdog_exception('cron', $e);
            }
        }
    }


    // Restore the user.
    $GLOBALS['user'] = $original_user;
    drupal_save_session($original_session_saving);

    return $return;

