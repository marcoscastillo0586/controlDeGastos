                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Men&uacute; Principal</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <?php foreach ($montoLugares as $key => $value){?>
                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                       <?php  print_r($value->nombre)?></div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">  <?php 
                                                $monto = $value->monto==''? 0 : $value->monto;
                                               print_r($monto);?></div>
                                            </div>
                                            <div class="col-auto">
                                          <img style="max-width:100px;" src="<?php  print_r($value->img)?>" alt=""></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>


                
                    </div>
             <label><p>TOTAL: <strong>$ <?php print_r($sumaTotal); ?></strong> </p></label>

                    <!-- Content Row -->
<div class="row">
                    <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Comparativa mensual</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="" id="consumoCategorias">
                                        <canvas id="graficoMensual"></canvas>
                                  <span id="totalconsumo"></span>
                                    </div>
                                </div>
                            </div>
                        </div> 
                </div>
                    <div class="row">

                      
                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Consumo Por categoria (último mes)</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Opciones de Gráficos:</div>
                                            <a id="uno" class="dropdown-item consumoCategoria" data-id="mesActual" href="#uno">Mes Actual</a>
                                            <a id="dos" class="dropdown-item consumoCategoria" data-id="mesAnterior" href="#dos">Mes Anterior</a>
                                            <a id="tres" class="dropdown-item consumoCategoria" data-id="ultimosDos"href="#tres">&Uacute;ltimos Dos Meses</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2" id="consumoCategorias">
                                        <canvas id="myPieChart"></canvas>
                                  <span id="totalconsumo"></span>
                                    </div>
                                    <!--<div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> Direct
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Social
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Referral
                                        </span>
                                    </div>-->
                                </div>
                            </div>
                        </div> 
                            <!-- Content Column -->
                        <div class="col-lg-6 mb-4" id="limitesGastos">
                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Limites De Gastos</h6>
                                </div>
                                <div class="card-body">
                                    
                                    
                                  
                                </div>
                            </div>

                         

                        </div> 
                    </div>
                

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
