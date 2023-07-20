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
