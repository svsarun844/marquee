<?php
require_once('../../config.php');
 
global $DB,$COURSE,$PAGE,$OUTPUT;
$PAGE->set_pagelayout('home');
$PAGE->set_title('Scroll News: List');

echo $OUTPUT->header();

if(is_siteadmin())
{
echo '<a class="btn btn-primary pull-right" style="margin-top:15px;" href="'.$CFG->wwwroot.'/blocks/marquee/add.php">Add new</a>';
$deleteId = optional_param('deleteId', 0, PARAM_INT);
$cid = optional_param('cid', 0, PARAM_INT);
if($deleteId) 
{
	$delId = $deleteId;
	//$cid = $_GET['cid'];
	$delQry = "DELETE FROM mdl_custom_marquee WHERE id = $delId";
	$execQry = $DB->execute($delQry);
	redirect($CFG->wwwroot."/blocks/marquee/list.php","Deleted Successfully");
}


         $setSelQry = "SELECT * FROM mdl_custom_marquee ORDER BY id DESC";
$executeSel = $DB->get_records_sql($setSelQry);
echo '<h2>Scroll News</h2>';
?>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 15px 15px 15px 5px;
}
td:first-child {
	font-weight: bold;
}
.active {
    background:#656EAA;
}
#nav {
	text-align: center;
	margin-top: 15px;
}
#nav a {
	padding: 5px;
	color: #fff;
}
</style>

<?php
   
  
 ?>
<div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="data">
<thead>
	<tr>
		<th width="30">S.No</th>
		
		<th>Description</th>
		<th width="100">Action</th>
	</tr>
</thead>
<?php
if(count($executeSel) > 0) { 
		 $i = 1;
	foreach($executeSel as $valExec) {
			
				$getValId = $valExec->id;
	?>
	<tbody>
	<tr>
		<td align="center"><?php echo $i++; ?></td>
		<td>
			<?php 
				echo $valExec->description;
			?>
		</td>
		
		<td><!--<a style="padding-left: 5px;" href="<?php echo $CFG->wwwroot; ?>/blocks/marquee/view.php?viewid=<?php echo $getValId; ?>">View</a> |--> <a class="fa fa-pencil-square-o" href="<?php echo $CFG->wwwroot; ?>/blocks/marquee/update.php?updateId=<?php echo $getValId; ?>"></a> | <a href="javascript:void(0);" class="fa fa-trash" onclick="if(confirm('Are you sure?')) window.location.href='<?php echo $CFG->wwwroot; ?>/blocks/marquee/list.php?deleteId=<?php echo $getValId; ?>';"></a></td>
	</tr>
	</tbody>
<?php	
	}
?>
</table>
</div>
<?php
} else {
	echo '<tr><td colspan="3" align="center"><div>No records found.</div></td></tr></table></div>';
}

}else { 
	echo "Access Denied"; 
}
    echo $OUTPUT->footer();
?>
<script>
$(document).ready(function(){
    $('#data').after('<div id="nav"></div>');
    var rowsShown = 10;
    var rowsTotal = $('#data tbody tr').length;
    var numPages = rowsTotal/rowsShown;
    for(i = 0;i < numPages;i++) {
        var pageNum = i + 1;
        $('#nav').append('<a href="javascript:void(0);" rel="'+i+'">'+pageNum+'</a> ');
    }
    $('#data tbody tr').hide();
    $('#data tbody tr').slice(0, rowsShown).show();
    $('#nav a:first').addClass('active');
    $('#nav a').bind('click', function(){

        $('#nav a').removeClass('active');
        $(this).addClass('active');
        var currPage = $(this).attr('rel');
        var startItem = currPage * rowsShown;
        var endItem = startItem + rowsShown;
        $('#data tbody tr').css('opacity','0.0').hide().slice(startItem, endItem).
                css('display','table-row').animate({opacity:1}, 300);
    });
});
</script>
