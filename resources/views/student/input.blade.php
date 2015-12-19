        <div class="row">
            <div class="input-group col-md-2">
                <label class="input-group-addon" for="initials">Initials</label>
                <input class="form-control" type="text" name="initials" id="initials"
                value="{{ old('initials', '') }}">
            </div>
        </div>

        <div class="row">
            <div class="input-group col-md-3">
                <label class="input-group-addon" for="external_id">ID</label>
                <input class="form-control" type="text" name="external_id" 
                    id="external_id" value="{{ old('external_id', '') }}">
            </div>
        </div>
