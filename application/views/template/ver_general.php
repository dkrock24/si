<!-- Main section-->
<section>
        <!-- Page content-->
        <div class="content-wrapper">
            <h3 style="height: 50px; font-size: 13px;">                
                <a href="../index" style="top: -12px;position: relative; text-decoration: none">
                    <button type="button" class="mb-sm btn btn-success"> Lista</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">Ver</button>
            </h3>
            

            <div class="row">
                <div class="col-lg-12">
                    <div id="panelDemo10" class="panel menu_title_bar"> 
                        <div class="panel-heading menuTop">Ver </div>

                        <div class="panel-body menuContent">    
                            <div class="row">
                                <div class="col-lg-6">
                                <table id="datatable1" class="table table-striped table-hover">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Campo</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                    <?php
                                    $cnt=1;
                                    
                                        foreach ($columns as $key => $value) {
                                            if( !base64_decode($data[0]->$key)  ){
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $cnt ; $cnt++;?>
                                                </td>
                                                <td>                                                    
                                                    <?php echo $key ?><br>                                                   
                                                </td>
                                                <td>
                                                    <span >
                                                        <?php echo $data[0]->$key; ?><br>
                                                    </span>
                                                </td>                                            
                                            </tr>
                                            <?php    
                                            }                                        
                                        }

                                    ?>       
                                        </tbody>
                                    </table>                                                             
                                   
                                </div>
                            </div>
                        </div>                                           
                          
                </div>
                    
            </div>
        </div>
    </section>


