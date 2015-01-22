<?php





function can_go()
{
	$sw = new SafeWriter;
	$lock = $sw->readData("queue_lock.txt");
	$time = intval($sw->readData("queue_time.txt"));
	
	if ((time()-$time[0] > 4) || ($lock[0] = ""))
	{
		return true;
	}
	else
	{
		return false;
	}
	
}

function take_lock($me)
{
	$sw = new SafeWriter;
	$sw->writeData("queue_lock.txt","w+",$me);
	$sw->writeData("queue_time.txt","w+",time());
}

function release_lock()
{
	$sw = new SafeWriter;
	$sw->writeData("queue_lock.txt","w+","");
}


	
?>