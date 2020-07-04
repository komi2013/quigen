#!/bin/bash -e
cd /Project/quigen
FILES=`/usr/bin/find ./ -amin -1`
KEY="/home/komatsu/.ssh/kagoya.key"
PATH="root@quigen.info:/tmp/"

# echo $FILES
for d in $FILES; do
    echo "${d}"
    if [ "`/bin/echo $d | /bin/grep -v .git`" ]; then
        F=`/bin/echo $d | /bin/sed 's/.\///'`
        echo $F $PATH$F
    fi

    
    # /usr/bin/rsync -avzPe "/usr/bin/ssh -i $KEY" $F $PATH$F
    # /usr/bin/rsync -avzPe "/usr/bin/ssh -i infra/autodeploy.sh root@quigen.info:/tmp/infra/autodeploy.sh
done