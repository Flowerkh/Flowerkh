@PostMapping("/test2")
public void test2() throws Exception{
    String url = "URL";
    String data = "DATA";
    
    TaskHandler taskHandler = new TaskHandler();
    taskHandler.TaskHandler(url,"POST", data);
}
