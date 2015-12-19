        <div class="row">
            <div class="input-group col-md-2">
                <label class="input-group-addon" for="year">Year</label>
                <input class="form-control" type="text" name="year" id="year" 
                    value="{{ old('year', Carbon\Carbon::now()->year) }}">
            </div>

        </div>

        <div class="row">
            <div class="input-group col-md-3">
                <label class="input-group-addon" for="term">Term</label>
                <select class="form-control" name="term" id="term">
                @foreach($terms as $term_key => $term_value)
                    {{ $selected = ($term_value->id == old('term') ) ? 'selected' : '' }}
                    
                    <option value="{{ $term_value->id }}" {{ $selected }}>
                        {{ $term_value->name }}
                    </option>
                @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="input-group col-md-3">
                <label class="input-group-addon" for="name">Name</label>
                <input class="form-control" type="text" name="name" id="name"
                value="{{ old('name', '') }}">
            </div>
        </div>
