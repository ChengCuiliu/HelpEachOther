<?php

require_once('connection.inc.php');

if($_REQUEST)
{
	$id 	= $_REQUEST['parent_id'];

	$sql = "SELECT * FROM itemcategory WHERE ParentId = ".$id;
	$result=$conn->query($sql);
	$num_rows = $result->num_rows;
	if($num_rows > 0)
		{?>
	<select name="sub_category" class="parent">
		<option value="" selected="selected">次级</option>
		<?php
		while ($rows=$result->fetch_assoc())
			{?>
		<option value="<?php echo $rows['CateId'];?>"><?php echo $rows['CateName'];?></option>
		<?php
	}?>
</select>
<?php
}
else{	echo '<label style="padding:7px;float:left; font-size:12px;">无下级分类！</label>';
}
}
?>
