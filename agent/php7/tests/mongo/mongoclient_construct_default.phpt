--TEST--
hook MongoClient::__construct default uri
--SKIPIF--
<?php
if (PHP_MAJOR_VERSION >= 7) die('Skipped: no mongo extension in PHP7.');
$conf = <<<CONF
security.weak_passwords:
  - ""
  - "root"
  - "123"
  - "123456"
  - "a123456"
  - "123456a"
  - "111111"
  - "123123"
  - "admin"
  - "user"
  - "mysql"
CONF;
include(__DIR__.'/../skipif.inc');
if (!extension_loaded("mongodb")) die("Skipped: mongo extension required.");
?>
--INI--
openrasp.root_dir=/tmp/openrasp
--FILE--
<?php
include(__DIR__.'/../timezone.inc');
$m = new MongoClient();
passthru('tail -n 1 /tmp/openrasp/logs/policy/policy.log.'.date("Y-m-d"));
?>
--EXPECTREGEX--
.*weak password detected.*