#!/bin/sh
#We record the status of the IAX2 Trunk
cd /root/ # I have script live in root,
# Set the peer name to monitor here
# ******
peername="YOURIAX2PEERNAME"
# ******
date >> slap.log
echo "Testing $peername peer" >> slap.log
/usr/sbin/asterisk -rx 'iax2 show peers' |grep -i $peername >> slap.log
/usr/sbin/asterisk -rx 'iax2 show peers' |grep -i $peername > reg_status
sleep 1
#We then Scan the Status and see if we're online or not...
TEST="OK"
if grep $TEST reg_status > /dev/null
then
echo "All OK Here" >> slap.log
exit #Abort, we are online, all is well...
fi
#IF we're this far down, we've lost IAX. Log the incident.
echo "we have a problem with $peername, Restarting it" >> slap.log
#Restart the IAX2 trunk. Delay required for some reason.
/usr/sbin/asterisk -rx 'module unload chan_iax2.so' >> slap.log
sleep 90;
/usr/sbin/asterisk -rx 'module load chan_iax2.so' > /dev/null
echo "Restarted it Now lets check status" >> slap.log
sleep 5;
/usr/sbin/asterisk -rx 'iax2 show peers' |grep -i $peername >> slap.log
#We record the status of the IAX2 Trunk
/usr/sbin/asterisk -rx 'iax2 show peers' |grep -i $peername > reg_status
sleep 1
#We then Scan the Status and see if we're online or not...
TEST="OK"
if grep $TEST reg_status > /dev/null
then
echo "All OK Here" >> slap.log
exit #Abort, we are online, all is well...
fi
#IF we're this far down, we've lost IAX. Log the incident.
echo "we have a problem with $peername, Restarting it" >> slap.log
#Restart the IAX2 trunk. Delay required for some reason.
/usr/sbin/asterisk -rx 'module unload chan_iax2.so' >> slap.log
sleep 120;
/usr/sbin/asterisk -rx 'module load chan_iax2.so' > /dev/null
echo "Restarted it Now lets check status" >> slap.log
sleep 5;
/usr/sbin/asterisk -rx 'iax2 show peers' |grep -i $peername >> slap.log
#We record the status of the IAX2 Trunk and exit
exit #Abort, we hope we are online, all is well...
