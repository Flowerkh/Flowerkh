package com.b2b_api.nhb.common;

import com.b2b_api.nhb.model.QueueInsert;
import com.b2b_api.nhb.service.TaskService;
import org.springframework.http.HttpMethod;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.http.client.HttpComponentsClientHttpRequestFactory;
import org.springframework.stereotype.Component;
import org.springframework.web.client.RestClientException;
import org.springframework.web.client.RestTemplate;

import javax.servlet.http.HttpServlet;
import java.util.Map;
import java.util.concurrent.TimeUnit;

@Component
public class TaskHandler extends HttpServlet {

    TaskService taskService = new TaskService();

    int sec = 1;

    public void TaskHandler(String strUrl, String method, String data) throws InterruptedException {

        QueueInsert taskInsert = new QueueInsert();
        taskInsert.setUrl(strUrl);
        taskInsert.setMethod(method);

        while(sec<=86400) {
            try {
                TimeUnit.SECONDS.sleep(sec); //접속 지연
                ResponseEntity<Map> result = this.restTemplate(sec).exchange(strUrl, this.method(method), null, Map.class); //url 접속 확인

                //200 성공
                if(result.getStatusCode() == HttpStatus.OK) {
                    taskInsert.setErrorMessage("OK");
                    taskInsert.setResult("success");
                    taskService.taskInsert(taskInsert); //insert log
                    break;
                }
            } catch(RestClientException e) {
                String error = strUrl + "," + e;
                taskInsert.setErrorMessage(error);
                taskInsert.setResult("fail");
                taskService.taskInsert(taskInsert); //insert log
                sec = sec*2;
                this.TaskHandler(strUrl,method, data); //접속 재시도 loop
            }
        }
    }

    //connection timeout
    public RestTemplate restTemplate(int ReadTime) {
        ReadTime = ReadTime * 1000;
        HttpComponentsClientHttpRequestFactory factory = new HttpComponentsClientHttpRequestFactory();
        factory.setReadTimeout(ReadTime); // read timeout
        factory.setConnectTimeout(3000); // connection timeout

        RestTemplate restTemplate = new RestTemplate(factory);
        return restTemplate;
    }

    //method type
    public HttpMethod method(String method) {
        HttpMethod result = null;

        switch(method) {
            case "GET" :
                result = HttpMethod.GET;
                break;
            case "POST" :
                result = HttpMethod.POST;
                break;
            case "PUT" :
                result = HttpMethod.PUT;
                break;
            case "PATCH" :
                result = HttpMethod.PATCH;
                break;
            case "DELETE" :
                result = HttpMethod.DELETE;
                break;
        }
        return result;
    }

}

