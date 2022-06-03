<?php 
require_once 'Parts/header.php'; 
require_once 'Parts/Modals/form-user.php'; 
require_once 'Parts/Modals/warn.php'; 
require_once 'Parts/Modals/confirm.php'; 
?>

<section class="users">
  <div class="container">
    <div class="row flex-lg-nowrap">
      <div class="col">
        <div class="row flex-lg-nowrap">
          <div class="col mb-3">
            <div class="e-panel card">
              <div class="card-body d-flex flex-column">
                
                <div class="cart-box row px-3">
                  
                  <button type="button" class="btn btn-primary col-2 bttn-add">Add</button>

                  <div class="cart-select col-8">
                    
                    <select class="form-control">
                      <option disabled selected>Please Select</option>
                      <option value="activate">Set active</option>
                      <option value="deactivate">Set not active</option>
                      <option value="delete">Delete</option>
                    </select>
                  
                  </div>

                  <button type="button" class="btn btn-primary col-2 bttn-select">Ok</button>
                
                </div>
                  
                  <div class="e-table flex-grow-1">
                    <div class="table-responsive table-lg mt-3">
                      
                      <table class="table table-bordered">
                        
                        <thead>
                          
                          <tr>
                            <th class="align-top">
                              <div
                                class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0">
                                <input type="checkbox" class="custom-control-input" id="all-items">
                                <label class="custom-control-label" for="all-items"></label>
                              </div>
                            </th>
                            <th class="max-width">Name</th>
                            <th class="sortable">Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                          </tr>
                        
                        </thead>
                                            
                        <tbody>
                         
                          <?php if (count($users) != 0): ?>
                            
                            <?php foreach ($users as $user): ?>

                              <tr data-id="<?php echo $user['id'] ?>">
                                
                                <td class="align-middle">
                                  <div
                                    class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">
                                    <input type="checkbox" class="custom-control-input" id="item-<?php echo $user['id'] ?>">
                                    <label class="custom-control-label" for="item-<?php echo $user['id'] ?>"></label>
                                  </div>
                                </td>
                                
                                <td class="text-nowrap align-middle user-name">
                                  <?php echo $user['first_name'] . ' ' . $user['last_name'] ?>
                                </td>
                                
                                <td class="text-nowrap align-middle">
                                  <span><?php echo $user['role'] ?></span>
                                </td>
                                
                                <td class="text-center align-middle">
                                  <i class="user-status fa fa-circle <?php echo !$user['status'] ? 'not-' : '' ?>active-circle"></i>
                                </td>
                                
                                <td class="text-center align-middle">
                                  <div class="btn-group align-top">
                                    <button class="btn btn-sm btn-outline-secondary badge bttn-update" type="button">Edit</button>
                                    <button class="btn btn-sm btn-outline-secondary badge bttn-delete" type="button">
                                      <i class="fa fa-trash"></i>
                                    </button>
                                  </div>
                                </td>
                              
                              </tr>

                            <?php endforeach; ?>

                          <?php else: ?>
                          
                            <tr class="no-users"><td colspan="5" class="h4">No Users</td></tr>

                          <?php endif; ?>
                        
                        </tbody>
                     
                      </table>
                    
                    </div>
                  </div>

                <div class="cart-box row px-3">
                  
                  <button type="button" class="btn btn-primary col-2 bttn-add" >Add</button>

                  <div class="cart-select col-8">
                    
                    <select class="form-control">
                      <option disabled selected>Please Select</option>
                      <option value="activate">Set active</option>
                      <option value="deactivate">Set not active</option>
                      <option value="delete">Delete</option>
                    </select>
                  
                  </div>

                  <button type="button" class="btn btn-primary col-2 bttn-select">Ok</button>
                
                </div>

              </div>
            </div>
          </div>
        </div>

    </div>
  </div>
</section>

<?php require_once 'Parts/footer.php'; ?>
