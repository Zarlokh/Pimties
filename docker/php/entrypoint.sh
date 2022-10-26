#!/usr/bin/env sh

uid=$(stat -c %u /srv)
gid=$(stat -c %g /srv)

: ${XDEBUG:=0}
: ${XDEBUG_CLI:=0}

: ${COLOR_ERROR:='\033[31;1;7m'}
: ${COLOR_SUCCESS:='\033[0;32m'}
: ${COLOR_NO:='\033[0m'}

disable_xdebug() {
    if [[ ! $1 = 1 ]]; then
        echo -e "[${COLOR_ERROR}xdebug is disabled${COLOR_NO}]"
        rm -f /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
    else
        echo -e "[${COLOR_SUCCESS}xdebug is enabled${COLOR_NO}]"
    fi
}

if [[ ${uid} == 0 ]] && [[ ${gid} == 0 ]]; then
    echo -e "${COLOR_ERROR}You should avoid using root on container${COLOR_NO}"

    exit 1
fi

sed -i -r "s/foo:x:\d+:\d+:/foo:x:$uid:$gid:/g" /etc/passwd
sed -i -r "s/bar:x:\d+:/bar:x:$gid:/g" /etc/group

sed -i "s/user = www-data/user = foo/g" /usr/local/etc/php-fpm.d/www.conf
sed -i "s/group = www-data/group = bar/g" /usr/local/etc/php-fpm.d/www.conf

user=$(grep ":x:$uid:" /etc/passwd | cut -d: -f1)

if [[ $# -eq 0 ]]; then
    disable_xdebug ${XDEBUG}

    php-fpm
else
    disable_xdebug ${XDEBUG_CLI}

    echo su-exec ${user} "$@"
    exec su-exec ${user} "$@"
fi
