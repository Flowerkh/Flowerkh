<?php

class Jandi
{
    private $db_connect;
    private $categories;
    private $webhooks;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->connect();

        $this->reset();
    }

    /**
     * 잔디 DB에 연결합니다.
     *
     * @return $this
     */
    private function connect()
    {
        if (!$this->db_connect) {

            $host = '47.176.39.145';
            $user = 'neiko';
            $password = 'qwe123qwe!@#';
            $database = 'developer';

            $this->db_connect = new PDO('mysql:host='.$host.';port=3306;dbname='.$database.';charset=utf8', $user, $password);
            $this->db_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db_connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }

        return $this;
    }

    /**
     * 설정된 사용자와 토픽 정보를 초기화합니다.
     *
     * @return $this
     */
    public function reset()
    {
        $this->categories = [];
        $this->webhooks = [
            'USER' => [],
            'TOPIC' => [],
        ];

        return $this;
    }

    /**
     * 카테고리를 설정합니다.
     *
     * @param  string|array  $category
     * @return $this
     */
    public function category($category)
    {
        $this->categories = (array)$category;

        return $this;
    }

    /**
     * 사용자를 설정합니다.
     *
     * @param  string|array  $userid
     * @return $this
     */
    public function user($userid)
    {
        $userids = (array)$userid;

        $sql = "SELECT w.target, w.target_id, w.category, w.url
                FROM jandi_users as u
                LEFT JOIN jandi_webhooks as w ON w.target = 'USER' AND u.id = w.target_id
                WHERE u.userid IN (".str_pad('', count($userids) * 3 - 2, '?, ', STR_PAD_LEFT).")
                ORDER BY u.id, w.id";
        $query = $this->db_connect->prepare($sql);
        $query->execute($userids);

        $this->webhooks['USER'] = $query->fetchAll();

        return $this;
    }

    /**
     * 토픽을 설정합니다.
     *
     * @param  string|array  $code
     * @return $this
     */
    public function topic($code)
    {
        $codes = (array)$code;

        $sql = "SELECT w.category, w.url
                FROM jandi_topics as t
                LEFT JOIN jandi_webhooks as w ON w.target = 'TOPIC' AND t.id = w.target_id
                WHERE t.code IN (".str_pad('', count($codes) * 3 - 2, '?, ', STR_PAD_LEFT).")
                ORDER BY t.id, w.id";
        $query = $this->db_connect->prepare($sql);
        $query->execute($codes);

        $this->webhooks['TOPIC'] = $query->fetchAll();

        return $this;
    }

    /**
     * 임의의 사용자가 jandi 사용자에 등록되어 있는지 확인합니다.
     *
     * @param  string  $userid
     * @return bool
     */
    public function hasUser($userid)
    {
        $sql = "SELECT count(*) as cnt
                FROM jandi_users
                WHERE userid = ?";
        $query = $this->db_connect->prepare($sql);
        $query->execute([$userid]);

        return !!$query->fetch()['cnt'];
    }

    /**
     * 임의의 사용자를 등록합니다.
     *
     * @param  array  $data
     * @return int
     */
    public function addUser($data)
    {
        $binds = [];
        foreach ($data as $key => $val) {
            $binds[':'.$key] = $val;
        }

        $sql = "INSERT INTO jandi_users
                (".implode(', ', array_keys($data)).")
                VALUES
                (".implode(', ', array_keys($binds)).")";
        $query = $this->db_connect->prepare($sql);
        $query->execute($binds);

        return $this->db_connect->lastInsertId();
    }

    /**
     * 임의의 코드가 jandi 토픽에 등록되어 있는지 확인합니다.
     *
     * @param  string  $code
     * @return bool
     */
    public function hasTopic($code)
    {
        $sql = "SELECT count(*) as cnt
                FROM jandi_topics
                WHERE code = ?";
        $query = $this->db_connect->prepare($sql);
        $query->execute([$code]);

        return !!$query->fetch()['cnt'];
    }

    /**
     * 임의의 토픽을 등록합니다.
     *
     * @param  array  $data
     * @return int
     */
    public function addTopic($data)
    {
        $binds = [];
        foreach ($data as $key => $val) {
            $binds[':'.$key] = $val;
        }

        $sql = "INSERT INTO jandi_topics
                (".implode(', ', array_keys($data)).")
                VALUES
                (".implode(', ', array_keys($binds)).")";
        $query = $this->db_connect->prepare($sql);
        $query->execute($binds);

        return $this->db_connect->lastInsertId();
    }

    /**
     * 설정된 Webhook이 있는지 조회하여 반환합니다.
     *
     * @param  string  $target  [USER, TOPIC]
     * @param  string  $category
     * @param  string  $id
     * @return bool
     */
    public function hasWebhook($target, $category, $id)
    {
        switch ($target) {
            case 'USER':
                return $this->hasUserWebhook($category, $id);
            case 'TOPIC':
                return $this->hasTopicWebhook($category, $id);
        }

        throw new Exception('유효하지 않은 코드입니다. 관리자에게 문의 바랍니다.');
    }

    /**
     * 사용자에게 설정된 Webhook이 있는지 조회하여 반환합니다.
     *
     * @param  string  $category
     * @param  string  $userid
     * @return bool
     */
    public function hasUserWebhook($category, $userid)
    {
        $sql = "SELECT count(*) as cnt
                FROM jandi_users as u
                LEFT JOIN jandi_webhooks as w ON w.target = 'USER' AND u.id = w.target_id
                WHERE u.userid = ?
                AND w.category = ?";
        $query = $this->db_connect->prepare($sql);
        $query->execute([$userid, $category]);

        return !!$query->fetch()['cnt'];
    }

    /**
     * Webhook을 생성합니다.
     *
     * @param  string  $target  [USER, TOPIC]
     * @param  string  $category
     * @param  string  $id
     * @param  string  $url
     * @return int
     */
    public function addWebhook($target, $category, $id, $url)
    {
            switch ($target) {
                case 'USER':
                    return $this->addUserWebhook($category, $id, $url);
                case 'TOPIC':
                    return $this->addTopicWebhook($category, $id, $url);
            }

            throw new Exception('유효하지 않은 코드입니다. 관리자에게 문의 바랍니다.');
    }

    /**
     * 사용자 Webhook을 생성합니다.
     *
     * @param  string  $category
     * @param  string  $userid
     * @param  string  $url
     * @return int
     */
    public function addUserWebhook($category, $userid, $url)
    {
        if (!$this->hasUser($userid)) {
            throw new Exception ('설정된 사용자가 없습니다. 관리자에게 문의 바랍니다.');
        }

        try {

            $sql = "INSERT INTO jandi_webhooks
                    (target, target_id, category, url)
                    (
                        SELECT 'USER', id, ?, ?
                        FROM jandi_users
                        WHERE userid = ?
                    )";
            $query = $this->db_connect->prepare($sql);
            $query->execute([$category, $url, $userid]);

            return $this->db_connect->lastInsertId();

        } catch (Exception $e) {
            throw new Exception ('Webhook 생성에 실패했습니다. 관리자에게 문의 바랍니다.');
        }
    }

    /**
     * 토픽 Webhook을 생성합니다.
     *
     * @param  string  $category
     * @param  string  $code
     * @param  string  $url
     * @return int
     */
    public function addTopicWebhook($category, $code, $url)
    {
        if (!$this->hasTopic($code)) {
            throw new Exception ('설정된 토픽이 없습니다. 관리자에게 문의 바랍니다.');
        }

        try {

            $sql = "INSERT INTO jandi_webhooks
                    (target, target_id, category, url)
                    (
                        SELECT 'TOPIC', id, ?, ?
                        FROM jandi_topics
                        WHERE code = ?
                    )";
            $query = $this->db_connect->prepare($sql);
            $query->execute([$category, $url, $code]);

            return $this->db_connect->lastInsertId();

        } catch (Exception $e) {
            throw new Exception ('Webhook 생성에 실패했습니다. 관리자에게 문의 바랍니다.');
        }
    }

    /**
     * 토픽에 설정된 Webhook이 있는지 조회하여 반환합니다.
     *
     * @param  string  $category
     * @return string  $code
     * @return bool
     */
    public function hasTopicWebhook($category, $code)
    {
        $sql = "SELECT count(*) as cnt
                FROM jandi_topics as t
                LEFT JOIN jandi_webhooks as w ON w.target = 'TOPIC' AND t.id = w.target_id
                WHERE t.code = ?
                AND w.category = ?";
        $query = $this->db_connect->prepare($sql);
        $query->execute([$code, $category]);

        return !!$query->fetch()['cnt'];
    }

    /**
     * Webhook으로 메세지를 전송합니다.
     *
     * @param  string  $title
     * @param  string|array  $description
     * @param  string  $color
     * @return array
     */
    public function send($title, $description = null, $color = '#1EC95B')
    {
        $data = [
            'body' => $title,
        ];

        if ($description !== null) {
            $data['connectColor'] = $color;
            $data['connectInfo'] = [];
            foreach ((array)$description as $desc) {
                if (is_array($desc)) {
                    array_push($data['connectInfo'], $desc);
                } else {
                    array_push($data['connectInfo'], [
                        'description' => $desc,
                    ]);
                }
            }
        }

        $headers = [
            'Content-Type: application/json',
            'Accept: application/vnd.tosslab.jandi-v2+json',
        ];

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $responses = [];

        foreach ($this->webhooks as $webhooks) {
            foreach ($webhooks as $webhook) {
                if (in_array($webhook['category'], $this->categories)) {
                    curl_setopt($ch, CURLOPT_URL, $webhook['url']);
                    $response = curl_exec($ch);

                    $responses[$webhook['url']] = $response;
                }
            }
        }

        curl_close($ch);

        return $responses;
    }
}
