<html>
	<head>
		<title>Home assignment</title>
		<style type="text/css">
			body{
				text-align: center;
			}
			#container{
				width: 450px;
				position:absolute;
				top:50px;
				left:50%;
				margin-left:-100px;
			}
			div{
				margin-top: 10px;
			}
			input{
				width: 150px;
			}
			select{
				width: 150px;
			}
		</style>

		<!-- stylesheet for 3d party library dtsel.js for datetime picker form inplementation -->
		<link rel="stylesheet" href="dtsel/dtsel.css" />

	</head>
	<body>
		<div id="container">
			<h2>Simple frontend for the assignment API</h2>
			<!-- Simple form to test API -->
			<form method="GET" action="api/assignment">
				<div>
					<label for="dateTimeStart">DateTime from:</label>
					<input name="dateTimeStart" id="dateTimeStart" class="form-control" />
					<!-- List of time zones -->
					<?php
						$OptionsArray = timezone_identifiers_list();
					    $select= '<select name="timeZoneStart">';
					    while (list ($key, $val) = each ($OptionsArray) ){
					        $select .='<option value="'.$val.'" >'.$val.'</option>';

					    }  // endwhile;
					    $select.='</select>';
					    echo $select;
				    ?>
				</div>

				<div>
				    <label for="dateTimeEnd">DateTime to:</label>
					<input name="dateTimeEnd" id="dateTimeEnd" class="form-control" />
					<!-- List of time zones -->
					<?php
						$OptionsArray = timezone_identifiers_list();
				        $select= '<select name="timeZoneEnd">';
				        while (list ($key, $val) = each ($OptionsArray) ){
				            $select .='<option value="'.$val.'" >'.$val.'</option>';

				        }  // endwhile;
				        $select.='</select>';
				        echo $select;
			        ?>

				</div>

				<div>
					<label for="meassure">Calculate interval in:</label>
					<select name="meassure">
						<option value="d">Days</option>
						<option value="wd">Week Days</option>
						<option value="w">Complete weeks</option>
					</select>
				</div>
				<div>
					<label for="convertTo">Convert result to:</label>
					<select name="convertTo">
						<option value="">none</option>
						<option value="s">Seconds</option>
						<option value="i">Minutes</option>
						<option value="h">Hours</option>
						<option value="y">Years</option>
					</select>
				</div>
				<div>
					<input type="submit" value="Send" name="btn"  />
				</div>
			</form>
		</div>
	</body>

	<!-- 3d party library dtsel.js for datetime picker form inplementation -->
	<script src="dtsel/dtsel.js"></script>
	<script type="text/javascript">

	  instance = new dtsel.DTS('input[name="dateTimeStart"]',  {
	    direction: 'BOTTOM',
	    dateFormat: "yyyy-mm-dd",
	    showTime: true,
	    timeFormat: "HH:MM:SS"
	  });

	  instance = new dtsel.DTS('input[name="dateTimeEnd"]',  {
	    direction: 'BOTTOM',
	    dateFormat: "yyyy-mm-dd",
	    showTime: true,
	    timeFormat: "HH:MM:SS"
	  });

	</script>

</html>