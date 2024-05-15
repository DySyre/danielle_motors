<?php
include "../../admin/session.php";
include "../../database/database.php";
date_default_timezone_set('Asia/Manila');
?>
<!DOCTYPE html>
<html lang="en-US" dir="ltr">

 <?php include "../../page_properties/header.php" ?>

  <body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <!-- navigation -->
      <?php include "../../page_properties/nav.php";?>
      <!-- /navigation -->
      <div class="content">
        <?php 
        include "content.php";
        ?>
        <!-- <div class="d-flex flex-center content-min-h">
          <div class="text-center py-9"><img class="img-fluid mb-7 d-dark-none" src="../../assets/img/spot-illustrations/2.png" width="470" alt="" /><img class="img-fluid mb-7 d-light-none" src="../../assets/img/spot-illustrations/dark_2.png" width="470" alt="" />
            <h1 class="text-800 fw-normal mb-5"><?php //echo $current_folder;?></h1><a class="btn btn-lg btn-primary" href="../../documentation/getting-started.html">Getting Started</a>
          </div>
        </div> -->
        <!-- footer -->
        <?php include "../../page_properties/footer.php"; ?>
        <!-- /footer -->
      </div>
      <!-- chat-container -->
      <?php include "../../page_properties/chat-container.php"; ?>
      <!-- /chat container -->
    </main><!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    <!-- theme customizer -->
    <?php include "../../page_properties/theme-customizer.php"; ?>
    <!-- /theme customizer -->

    <?php include "../../page_properties/footer_main.php"; ?>
  </body>

  <script>
    $(document).ready(function() {
      function getDailyReport() {
        $.ajax({
          url: '../../PHP - process_files/daily-report.php',
          method: 'POST',
          dataType: 'json',
          success: function(json) {
            var expenses = json.expenses + json.delivery;
            var profit = json.sales - expenses;

            if (json.sales == 0) {
              var options = {
                  chart: {
                      type: 'donut'
                  },
                  series: [1],
                  labels: ['No Data'],
                  colors: ['#F0F0F0'],
                  responsive: [{
                      breakpoint: 480,
                      options: {
                          chart: {
                              width: 200
                          },
                          legend: {
                              position: 'bottom'
                          }
                      }
                  }]
              };
            } else {
              var options = {
                  chart: {
                      type: 'donut'
                  },
                  series: [json.sales, expenses, profit],
                  labels: ['Sales', 'Expense', 'Profit'],
                  colors: ['#008FFB', '#FF0000', '#00E396'],
                  responsive: [{
                      breakpoint: 480,
                      options: {
                          chart: {
                              width: 200
                          },
                          legend: {
                              position: 'bottom'
                          }
                      }
                  }]
              };
            }
            
            var chart = new ApexCharts($("#daily-chart")[0], options);

            chart.render();
          },
          error: function(xhr, status, error) {
              // Handle errors if any
              console.error("Error fetching data:", error);
          }
        });
      }

      function getWeeklyReport() {
        $.ajax({
          url: '../../PHP - process_files/weekly-report.php',
          method: 'POST',
          dataType: 'json',
          success: function(json) {
            console.log(json);
            
            var weekly_expenses = [];
            for (var i = 0; i < json.expenses.length; i++) {
                var result = json.expenses[i] + json.delivery[i];
                weekly_expenses.push(result);
            }

            var profit = [];
            for (var i = 0; i < json.sales.length; i++) {
                var result = json.sales[i] - weekly_expenses[i];
                profit.push(result);
            }

            var options = {
                chart: {
                    type: 'bar',
                    height: 400,
                    stacked: true,
                    toolbar: {
                        show: true
                    },
                    zoom: {
                        enabled: true
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        borderRadius: 10
                    },
                },
                series: [{
                    name: 'Sales',
                    data: json.sales
                }, {
                    name: 'Expenses',
                    data: weekly_expenses
                }, {
                    name: 'Profit',
                    data: profit
                }],
                xaxis: {
                    categories: json.date,
                },
                yaxis: {
                  decimalsInFloat: 2
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'left',
                    offsetX: 40
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return "₱" + val.toLocaleString();
                        }
                    }
                },
                colors: ['#008FFB', '#FF0000', '#00E396'],
                dataLabels: {
                    enabled: false
                }
            };
            
            var chart = new ApexCharts($("#weekly-chart")[0], options);
            chart.render();
          },
          error: function(xhr, status, error) {
              // Handle errors if any
              console.error("Error fetching data:", error);
          }
        });
      }

      getDailyReport();
      getWeeklyReport();
    });
  </script>

<!-- Mirrored from prium.github.io/phoenix/v1.13.0/pages/starter.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 04 Aug 2023 05:15:14 GMT -->
</html>