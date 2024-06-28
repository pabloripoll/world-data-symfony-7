# Docker MySQL 5.7

## From

- https://hub.docker.com/_/mysql
- https://hub.docker.com/r/mysql/mysql-server/
- https://github.com/mysql/mysql-docker/
- https://dev.mysql.com/doc/relnotes/mysql/5.7/en/

## Issue from local image

https://discussion.fedoraproject.org/t/how-to-remove-expired-gpg-key-installed-by-mysql/100703/2
https://support.cpanel.net/hc/en-us/articles/4419382481815-MySQL-GPG-keys-expired-preventing-installation-upgrade-of-MySQL-packages-from-the-official-repository
https://forums.mysql.com/read.php?11,712128,712680

## Info

Version
```
$ mysql --version
mysql  Ver 14.14 Distrib 5.7.44, for Linux (x86_64) using  EditLine wrapper
```

Operate System
```
$ cat /etc/os-release

NAME="Oracle Linux Server"
VERSION="7.9"
ID="ol"
ID_LIKE="fedora"
VARIANT="Server"
VARIANT_ID="server"
VERSION_ID="7.9"
PRETTY_NAME="Oracle Linux Server 7.9"
ANSI_COLOR="0;31"
CPE_NAME="cpe:/o:oracle:linux:7:9:server"
HOME_URL="https://linux.oracle.com/"
BUG_REPORT_URL="https://github.com/oracle/oracle-linux"

ORACLE_BUGZILLA_PRODUCT="Oracle Linux 7"
ORACLE_BUGZILLA_PRODUCT_VERSION=7.9
ORACLE_SUPPORT_PRODUCT="Oracle Linux"
ORACLE_SUPPORT_PRODUCT_VERSION=7.9
```
