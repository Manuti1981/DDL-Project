<?php 
	 $controller =  $this->request->getParam('controller');
	 $action =  $this->request->getParam('action');
	 
	 
?>
<?php $cakeDescription = 'Adgatemedias';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?= $cakeDescription ?>:
        <?= $this->fetch('title') ?></title>
    <link rel="icon" type="image/x-icon" href="<?php echo $base_url?>img/assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
	<?php  
		echo $this->Html->css('topltr/bootstrap/css/bootstrap.min.css'); 
		echo $this->Html->css('topltr/assets/css/plugins.css'); 
		echo $this->Html->css('topltr/assets/css/structure.css'); 
	?> 
    <!-- END GLOBAL MANDATORY STYLES -->
	<!--  BEGIN CUSTOM STYLE FILE  -->      
    <?php  echo $this->Html->css('topltr/plugins/jquery-step/jquery.steps.css');  ?>       
    <?php  echo $this->Html->css('topltr/assets/css/tables/table-basic.css');  ?>   
    <!--  END CUSTOM STYLE FILE  -->  
    <!-- BEGIN PAGE LEVEL STYLES -->
	<?php   
		echo $this->Html->css('topltr/plugins/table/datatable/datatables.css'); 
		echo $this->Html->css('topltr/plugins/table/datatable/dt-global_style.css'); 
		echo $this->Html->css('topltr/plugins/table/datatable/custom_dt_multiple_tables.css');  
	?>       
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css"/>  
	<style>
	div.dataTables_wrapper div.dataTables_filter label {
  display: block;
}
 
div.dataTables_wrapper div.dataTables_filter input {
  width: 655px;
  margin: 0;
}
.table > tbody > tr > td {
  border: none;
  color: #000;
  font-size: 13px;
  letter-spacing: 1px;
}
	</style>
     <!-- END PAGE LEVEL STYLES --> 
	<link rel="shortcut icon" type="image/x-icon" href="#1">
</head>
<body class="sidebar-noneoverflow">  
    <div class="main-container" id="container"> 
        <div class="overlay"></div>
        <div class="search-overlay"></div>
 
        <div id="content" class="main-content paddingtopmobile">
			<?= $this->fetch('content') ?>   
        </div>
     </div>
     
	<?php echo $this->Html->script('topltr/assets/js/libs/jquery-3.1.1.min.js'); ?>
	<?php echo $this->Html->script('topltr/plugins/jquery-ui/jquery-ui.min.js'); ?> 
	<?php echo $this->Html->script('topltr/bootstrap/js/bootstrap.min.js'); ?>   
	<?php echo $this->Html->script('topltr/assets/js/app.js'); ?>  
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script> 
	 <?php echo $this->Html->script('topltr/plugins/table/datatable/datatables.js'); ?>  
	<script type="text/javascript" src=" https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js "></script> 
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.js"></script> 
	<script> 
		$(document).ready(function() {
		   var dataSrc = [];

		   var table = $('#zero-config').DataTable({
			  'initComplete': function(){
				 var api = this.api();

				 // Populate a dataset for autocomplete functionality
				 // using data from first, second and third columns
				 api.cells('tr', [0]).every(function(){
					// Get cell data as plain text
					var data = $('<div>').html(this.data()).text();           
					if(dataSrc.indexOf(data) === -1){ dataSrc.push(data); }
				 });
				 
				 // Sort dataset alphabetically
				 dataSrc.sort();
				
				 // Initialize Typeahead plug-in
				 $('.dataTables_filter input[type="search"]', api.table().container())
					.typeahead({
					   source: dataSrc,
					   afterSelect: function(value){
						  api.search(value).draw();
					   }
					}
				 );
			  }
		   });
		});

       /* $('#zero-config').DataTable({
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
			"ordering": true,
			"columnDefs": [{
			  "orderable": false,
			  "targets": "no-sort"
			}],
			"responsive": true, 
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 20 
        }); */
    </script> 
    <!-- END PAGE LEVEL SCRIPTS -->
	<?php  //echo $this->element('sql_dump'); ?>
</body>
</html>