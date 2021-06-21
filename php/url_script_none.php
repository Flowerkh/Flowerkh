$no_search = array('_ga','_C_','utm_source','utm_medium','utm_campaign','_T_','utm_expid','utm_referrer','gclid');
$splash_char = array('%27','%21','%3C','%3E%','%2F','%3B','%3A','%2D','char', 'cast', 'create', 'alter', 'update', 'delete', 'exec');
$search_char = array('script','>','<','+',':','"','\'','=','-','%27','%21','%3C','%3E%','%2F','%3B','%3A','%2D','char', 'cast', 'create', 'alter', 'update', 'delete', 'exec');


if (is_array($_GET)) {
    foreach ($_GET as $_tmp['k'] => $_tmp['v']) {
        if(in_array($_tmp['k'],$no_search)){
            continue;
        }
        if (is_array($_GET[$_tmp['k']])) {
            foreach ($_GET[$_tmp['k']] as $_tmp['k1'] => $_tmp['v1']) {
                if (in_array($_GET[$_tmp['k']][$_tmp['k1']], in_array($_GET[$_tmp['k']], $splash_char)) || in_array($_GET[$_tmp['k']], $splash_char)) {
                    $_GET[$_tmp['k']][$_tmp['k1']] = ${$_tmp['k']}[$_tmp['k1']] = "";
                    echo "<script>alert(\"잘못된 접근 입니다.\")</script>";
                    exit;
                }
                foreach ($search_char as $_char['k'] => $_char['v']) {
                    if (strpos($_GET[$_tmp['k']][$_tmp['k1']], $_char['v']) || strpos($_GET[$_tmp['k']], $_char['v'])){
                        echo "<script>alert(\"잘못된 접근 입니다.\")</script>";
                        exit;
                    }
                }
            }
        }
        else {
            if (in_array($_GET[$_tmp['k']][$_tmp['k1']], in_array($_GET[$_tmp['k']], $splash_char)) ||  in_array($_GET[$_tmp['k']], $splash_char)) {
                $_GET[$_tmp['k']] = ${$_tmp['k']} = "";
                echo "<script>alert(\"잘못된 접근 입니다.\")</script>";
                exit;
            }
            foreach ($search_char as $_char['k'] => $_char['v']) {
                if (strpos($_GET[$_tmp['k']][$_tmp['k1']], $_char['v']) || strpos($_GET[$_tmp['k']], $_char['v'])){
                    echo "<script>alert(\"잘못된 접근 입니다.\")</script>";
                    exit;
                }
            }
        }
    }
}
if (is_array($_POST)){
    foreach($_POST as $_tmp['k'] => $_tmp['v']) {
        if(in_array($_tmp['k'],$no_search)){
            continue;
        }
        if (is_array($_POST[$_tmp['k']])) {
            foreach ($_POST[$_tmp['k']] as $_tmp['k1'] => $_tmp['v1']) {
                if (in_array($_POST[$_tmp['k']][$_tmp['k1']], in_array($_POST[$_tmp['k']], $splash_char))) {
                    $_POST[$_tmp['k']][$_tmp['k1']] = ${$_tmp['k']}[$_tmp['k1']] = "";
                    alert("잘못된 접근 입니다.");
                }
            }
        }
        else {
            if (in_array($_POST[$_tmp['k']][$_tmp['k1']], in_array($_POST[$_tmp['k']], $splash_char))) {
                $_POST[$_tmp['k']] = ${$_tmp['k']} = "";
                alert("잘못된 접근 입니다.");
            }
        }
    }
}
