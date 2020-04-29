<?php
include('db.php');
$sql="select id,name from country";
$countrylist = $conn -> query($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>PHP Ajax Searchable Country State City Dropdown.</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!---------------- External API's  --------------------------->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <!---------------------- * * * * * * * ----------------------->



    <style type="text/css">
        #divLoading {
            display: none;
        }

        #divLoading.show {
            display: block;
            position: fixed;
            z-index: 100;
            background-image: url('http://loadinggif.com/images/image-selection/3.gif');
            background-color: #666;
            opacity: 0.4;
            background-repeat: no-repeat;
            background-position: center;
            left: 0;
            bottom: 0;
            right: 0;
            top: 0;
        }

        #loadinggif.show {
            left: 50%;
            top: 50%;
            position: absolute;
            z-index: 101;
            width: 32px;
            height: 32px;
            margin-left: -16px;
            margin-top: -16px;
        }

    </style>
</head>

<body>
    <div class="container">
        <center><h1>PHP Ajax Searchable Country State City Dropdown.</h1></center>
        <form>
            
                
                    <div class="form-group">
                        <label for="country">Country</label>
                        <select class="form-control" data-live-search-placeholder="Search.."   id="country" data-live-search-style="startsWith" data-live-search="true">
                            <option value="-1" disabled selected>Select Country</option>
                            <?php
							while($country = mysqli_fetch_array($countrylist)){
								?>
                            <option value="<?php echo $country['id']?>"><?php echo $country['name']?></option>
                            <?php
							}
							?>
                        </select>
                   
                </div>
                
                    <div class="form-group">
                        <label for="state">State</label>
                        <select class="form-control" id="state" data-live-search-placeholder="Search.."  data-live-search-style="startsWith" data-live-search="true">
                            <option disabled selected>Select State</option>
                        </select>
                  
                </div>
               
                    <div class="form-group">
                        <label for="city">City</label>
                        <select class="form-control" data-live-search-placeholder="Search.." data-live-search-style="startsWith" data-live-search="true"  id="city">
                            <option selected>Select City</option>
                        </select>
                   
                
            </div>
        </form>
    </div>
    <div id="divLoading"></div>

    <script>
       

        $(function () {
    $('select').selectpicker();
});
   
        $(document).ready(function() {
            jQuery('#country').change(function() {
                var id = jQuery(this).val();
                if (id == '-1') {        
                    alert("Please select corect country");
                    jQuery('#state').html('<option value="-1">Select State</option>');
                } else {
                    
                    
                    $("#divLoading").addClass('show');
                    jQuery('#state').html('<option disabled selected  value="-1">Select State</option>');
                    jQuery('#city').html('<option selected  value="-1">Select City</option>');
                    jQuery.ajax({
                        type: 'post',
                        url: 'get_data.php',
                        data: 'id=' + id + '&type=state',
                        success: function(result) {
                            $("#divLoading").removeClass('show');
                            jQuery('#state').append(result);
                            $('#state').selectpicker('refresh');
                        }
                    });
                }
            });
            jQuery('#state').change(function() {
                var id = jQuery(this).val();
                if (id == '-1') {
                    jQuery('#city').html('<option selected  value="-1">Select City</option>');
                } else {
                    $("#divLoading").addClass('show');
                    jQuery('#city').html('<option selected value="-1">Select City</option>');
                    jQuery.ajax({
                        type: 'post',
                        url: 'get_data.php',
                        data: 'id=' + id + '&type=city',
                        success: function(result) {
                            $("#divLoading").removeClass('show');
                            jQuery('#city').append(result);
                             $('#city').selectpicker('refresh');
                        }
                    });
                }
            });
        });


    </script>

</body>

</html>
