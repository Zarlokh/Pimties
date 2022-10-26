#!/bin/sh

if [ "$_" = "$0" ]; then
    echo "WARN: you must source this file: '. docker/set-env.sh'"
fi

contains() {
    string="$1"
    substring="$2"
    if test "${string#*$substring}" != "$string"; then
        return 0
    fi
    return 1
}

appDir=$PWD
dockerBinDir=$appDir/docker/bin
if [ ! -d $dockerBinDir ]; then
    echo "$dockerBinDir does not exists"
else
    contains "$PATH" "$dockerBinDir" || export PATH=$dockerBinDir:$PATH
fi