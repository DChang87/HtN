#include <pebble.h>

#define KEY_MSSG 0

static Window *s_main_window;
static TextLayer *s_mssg_layer;
static char s_mssg[] = "Hello World";

/*
static void inbox_received_callback(DictionaryIterator *iterator, void *context) {

}

static void inbox_dropped_callback(AppMessageResult reason, void *context) {
  APP_LOG(APP_LOG_LEVEL_ERROR, "Message dropped!");
}

static void outbox_failed_callback(DictionaryIterator *iterator, AppMessageResult reason, void *context) {
  APP_LOG(APP_LOG_LEVEL_ERROR, "Outbox send failed!");
}

static void outbox_sent_callback(DictionaryIterator *iterator, void *context) {
  // Insert other 'sending' code here

  APP_LOG(APP_LOG_LEVEL_INFO, "Outbox send success!");
}
*/
static void main_window_load(Window *window) {
  // Create time TextLayer
  s_mssg_layer = text_layer_create(GRect(0, 55, 144, 50));
  text_layer_set_background_color(s_mssg_layer, GColorClear);
  text_layer_set_text_color(s_mssg_layer, GColorBlack);
  text_layer_set_text(s_mssg_layer, s_mssg);

  // Add it as a child layer to the Window's root layer
  layer_add_child(window_get_root_layer(window), text_layer_get_layer(s_mssg_layer));
}

static void main_window_unload(Window *window) {
  // Destroy TextLayer
  text_layer_destroy(s_mssg_layer);
}

static void init() {
  // Create main Window element and assign to pointer
  s_main_window = window_create();

  // Set handlers to manage the elements inside the Window
  window_set_window_handlers(s_main_window, (WindowHandlers) {
    .load = main_window_load,
    .unload = main_window_unload
  });

// Current time + 30 seconds
time_t future_time = time(NULL) + 10;

// Schedule wakeup event and keep the WakeupId in case it needs to be queried
int s_wakeup_id = wakeup_schedule(future_time, 0, true);

// Persist to allow wakeup query after the app is closed.
persist_write_int(12, s_wakeup_id);

// Show the Window on the watch, with animated=true
window_stack_push(s_main_window, true);

/*
// Register callbacks
app_message_register_inbox_received(inbox_received_callback);
app_message_register_inbox_dropped(inbox_dropped_callback);
app_message_register_outbox_failed(outbox_failed_callback);
app_message_register_outbox_sent(outbox_sent_callback);


// Open App Message
app_message_open(app_message_inbox_size_maximum(), app_message_outbox_size_maximum());
*/
}

static void deinit() {
  // Destroy Window
  window_destroy(s_main_window);
}

static void wakeup_handler(WakeupId id, int32_t reason) {
  // A wakeup event has occurred
  init();
  app_event_loop();
  deinit();

}
int main() {
	wakeup_service_subscribe(wakeup_handler);
  init();
  app_event_loop();
  deinit();
  return 0;
}
