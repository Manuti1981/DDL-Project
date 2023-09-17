<div class="layout-px-spacing"> 
                <div class="row layout-top-spacing" id="cancel-row">
                
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="widget-content widget-content-area br-6"> 
							 <p>&nbsp;</p>
							 <p>&nbsp;</p>
                            <div class="table-responsive mb-4 mt-4">
								<?= $this->Flash->render() ?>
								<?= $this->Form->create(null, ['url' => ['action' => 'deleteAll']]) ?>
                                <table id="zero-config" class="table table-hover" style="width:100%">
                                    <thead>
										 <tr>
											<th class="no-sort">Name</th> 
											<th class="no-sort">Requirements</th>
											<th class="no-sort">Description</th>
											<th>ECP </th>
											<th class="no-sort">URL</th>  
										</tr>
                                    </thead>
                                    <tbody>
										<?php foreach ($data as $result):   ?>
                                        <tr>

											<td>
											<?= $this->Custom->decrypt_code_env($result->name); ?> &nbsp;</td> 
											<td> <?= $this->Custom->decrypt_code_env($result->requirements); ?>  &nbsp;</td> 
											<td> <?= $this->Custom->decrypt_code_env($result->description); ?>   &nbsp;</td> 
											<td><?= h($result->epc); ?>  &nbsp;</td> 
											<td> <a href="<?= $this->Custom->decrypt_code_env($result->click_url); ?>" target="_blank">Click Here</a>&nbsp;</td>  
										 
                                           
                                        </tr>
                                         <?php endforeach; ?>
                                    </tbody> 
                                </table>
								 
								<?= $this->Form->end() ?>
								<?= $this->fetch('postLink'); ?>
                            </div>
                        </div>
                    </div>

                </div>

                </div>
				
				 