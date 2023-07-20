package com.b2b_api.nhb.service;

import com.b2b_api.nhb.mapper.TaskMapper;
import com.b2b_api.nhb.model.QueueInsert;
import org.springframework.stereotype.Service;

@Service
public class TaskService {

    TaskMapper taskMapper = new TaskMapper() {
        @Override
        public boolean insertQueue(QueueInsert taskInsert) {
            return false;
        }
    };

    public void taskInsert(QueueInsert queueInsert) {
        taskMapper.insertQueue(queueInsert);
    }
}
