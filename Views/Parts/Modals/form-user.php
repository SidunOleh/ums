<!-- User Form Modal -->
<div class="modal" id="user-form-modal" tabindex="-1" aria-labelledby="user-form-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="user-form-modal"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-body">

        <div class="errors">
        </div>
       
        <form method="POST" id="user-form">
          
          <div class="form-group">
            <label for="first-name" class="col-form-label">First Name:</label>
            <input type="text" class="form-control" id="first-name" name="first_name">
          </div>
          
          <div class="form-group">
            <label for="last-name" class="col-form-label">Last Name:</label>
            <input type="text" class="form-control" id="last-name" name="last_name">
          </div>

          <div class="form-group">
            <label for="role" class="col-form-label">Role:</label>
            
            <select class="form-control" id="role" name="role">
              <option selected value="user">User</option>
              <option value="admin">Admin</option>
            </select>
          
          </div>

          <div class="form-group">
            <p class="col-form-label">Status:</p>
            <input type="checkbox" id="status" class="cbx hidden" name="status"/>
            <label for="status" class="lbl"></label>
          </div>  

        </form>
      
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary bttn-send">Save</button>
      </div>
    
    </div>
  </div>
</div>
