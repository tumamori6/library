URLBASE=http://devimages.apple.com/iphone/samples/bipbop

SUBDIR=$1
mkdir -p $SUBDIR
cd $SUBDIR
wget $URLBASE/$SUBDIR/plog_index.m3u8
for i in `seq 0 24`
do
  fileno=`echo $i`
  wget $URLBASE/$SUBDIR/fileSequence$fileno.ts
  if [ $? -gt 0 ]; then
    exit 99
  fi
done

cd ..