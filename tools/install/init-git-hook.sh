#!/bin/sh

for file in git-hook/* ; do
  if [ -f "./.git/hooks/$(basename "$file")" ] ; then
    echo "[SKIP] ./.git/hooks/$(basename "$file") already exist"
  else
    ln -s "../../$file" .git/hooks/
  fi
done