<style>
  #portfolio-list li{
    border: 1px solid #fff;
  }
 #portfolio-list li:hover .more{
    top:68% !important;
  }
</style>
<!-- Start Page Banner -->
    <div class="page-banner no-subtitle">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h2><?php echo ($this->input->get('type')==1)?'Arts Clinic':'Sports Clinic';?></h2>
          </div>
          <div class="col-md-6">
            <ul class="breadcrumbs">
              <li><a href="?content=home.php">Home</a></li>
              <li><?php echo ($this->input->get('type')==1)?'Arts':'Sports';?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- End Page Banner -->
 <!-- Start Portfolio Section -->
    <input type = "hidden" id = "clinic_type" value = "<?=$this->input->get('type');?>">
    <!-- Start Content -->
    <div id="content">
      <div class = "container" id = "clinic">
        <!-- Page Content -->
        <div class="page-content">
          <!-- Classic Heading -->
          <h4 class="classic-title"><span><?php echo ($this->input->get('type')==1)?'Arts':'Sports';?> Clinic List</span></h4> 
        <!-- Stat Search -->
            <div class="search-side">
              <a class="show-search"><i class="fa fa-search"></i></a>
              <div class="search-form">
                  <input type="text" value="" name="searchClinic" id="searchClinic" placeholder="Search clinic..."/>
              </div>
            
            <!-- End Search -->
          </div>
        
        <!-- Divider -->
        <div class="hr1 margin-top"></div>

        <div class="section full-width-portfolio" style="border-top:0; border-bottom:0; background:#fff;">

          <!-- Start Recent Projects Carousel -->
          <ul id="portfolio-list" data-animated="fadeIn">
          </ul>
          <!-- End Recent Projects Carousel -->
        
        <!-- End Portfolio Section -->
        </div>
        </div>
    </div>

        <!-- javascripts -->
    <script type="text/javascript" src="assets/js/clinics.js"></script>