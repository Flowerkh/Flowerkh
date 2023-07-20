/**
 * 결과 관련 Controller
 */

package com.b2b_api.nhb.controller;

import com.b2b_api.nhb.common.TaskHandler;
import com.b2b_api.nhb.mapper.CommonMapper;
import com.b2b_api.nhb.model.ErrorResponse;
import com.b2b_api.nhb.model.PrimaryKeyWithKit;
import com.b2b_api.nhb.service.ResultService;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.validation.Errors;
import org.springframework.validation.annotation.Validated;
import org.springframework.web.bind.annotation.*;

import java.net.URISyntaxException;
import java.util.HashMap;

@RestController
@RequestMapping("/results")
@Slf4j
public class ResultController {
    @GetMapping("/test")
    public void test() throws Exception{
        String url = "http://172.19.85.147:0001/";
        String data = "{'test':'test'}";

        TaskHandler taskHandler = new TaskHandler();
        taskHandler.TaskHandler(url,"GET", data);
    }

    @PostMapping("/test2")
    public void test2() throws Exception{
        String url = "https://gentok.com/sr/2110130001";
        String data = "{'test':'test'}";

        TaskHandler taskHandler = new TaskHandler();
        taskHandler.TaskHandler(url,"POST", data);
    }
}
