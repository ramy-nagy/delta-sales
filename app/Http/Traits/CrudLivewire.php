<?php

namespace App\Http\Traits;

use Livewire\WithPagination;

use Hash, Cache, DB, File, Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

trait CrudLivewire
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    //protected $listeners = ['destroy'];
    public function getListeners()
    {
        return $this->listeners + [
            'destroy' => 'destroy',
        ];
    }
    // For General Query
    public $entries = 10, $search = '', $SearchInColumn = 'name', $Ids = [], $selectAll = false, $false_true = [false, true, 0, 1];
    public $Fillable = [];
    // create & update Mode
    public $createdMode = false, $updateMode = false;

    // Trashed options & Completed
    public $Only_Trashed = false, $With_Trashed = false, $Completed = false;

    // search in dates 
    public $Date_values = [1, 7, 30, 60, 90], $Today = false, $DateFrom = '', $calendar_From = '', $calendar_To = '';

    // for dynamic model & view in mount
    public function mount($model, $view)
    {
        $this->view  = $view;
        $this->model = $model;

        foreach ($model->getFillable() as $fillable) {
            $this->$fillable = '';
            $this->Fillable[] = $fillable;
        }
    }
    //Only_Trashed
    public function selectAll()
    {
        dd($this->Ids);
    }

    // dispatchBrowserEvent
    public function alert($type = null, $message = null)
    {
        $this->dispatchBrowserEvent('alert', ['type' => $type, 'message' => $message]);
    }
    public function alert_delete($type = null, $message = null, $id = null)
    {
        $this->dispatchBrowserEvent('delete', ['type' => $type, 'message' => $message, 'id' => $id]);
    }
    // resetInputFields
    private function resetInputFields()
    {
        foreach ($this->Fillable as $fillable) {
            $this->$fillable = '';
        }
    }
    // cancel
    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }
    // SearchInColumn
    public function updatedSearchInColumn($value)
    {
        if (is_array($this->Fillable)) {
            if (in_array($value, $this->Fillable)) {
                $this->SearchInColumn = $value;
            } else {
                $this->SearchInColumn = 'name';
                $this->alert('error', 'Please select a valid column for search . (48)');
            }
        } else {
            $this->SearchInColumn = 'name';
        }
    }
    // Create
    public function Create()
    {
        $this->createdMode = !$this->createdMode;
    }
    //Only_Trashed
    public function Only_Trashed()
    {
        $this->With_Trashed = true  ? false : false;
        $this->Only_Trashed = !$this->Only_Trashed;
    }
    //With_Trashed
    public function With_Trashed()
    {
        $this->Only_Trashed = true  ? false : false;
        $this->With_Trashed = !$this->With_Trashed;
    }
    // Completed
    public function Completed()
    {
        $this->Completed = !$this->Completed;
    }
    // DateFrom
    public function updatedDateFrom($value)
    {
        if (!in_array($value, $this->Date_values)) {
            $this->DateFrom = false;
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => "Please Select Valid Date (24)"]);
        } else {
            $this->Today = true  ? false : false;
            $this->DateFrom = $value;
        }
    }

    // Today
    public function Today()
    {
        $this->DateFrom = true  ? false : false;
        $this->Today = !$this->Today;
    }

    // DateFrom to
    public function calendar_From()
    {
        dd($this->calendar_From);
        if (!$this->calendar_From && !$this->calendar_To) {
        } elseif (!checkdate($this->calendar_From) && checkdate($this->calendar_To)) {
        } else {
            dd(66);
        }
    }
    // store method
    public function store()
    {
        $validated = $this->validate();
        DB::beginTransaction();
        try {
            $this->model::create($validated);
            DB::commit();
            $this->alert('success', 'Created Successfully');
            $this->resetInputFields();
        } catch (\Exception $e) {
            DB::rollback();
            $this->alert('error', 'Wrong Created');
            $this->resetInputFields();
        }
    }
    //  edit method
    public function edit($id)
    {
        //$id   = un_hash_id($id);
        try {
            $edit_model = $this->model::findOrFail($id);
            foreach ($this->model->getFillable() as $Fillable) {
                $this->$Fillable = $edit_model->$Fillable;
            }
            $this->user_id = $id;
            $this->updateMode = true;
        } catch (\Exception $e) {
            $this->alert('error', 'Wrong ID');
        }
    }
    //  update method
    public function update()
    {
        $validated = $this->validate();
        DB::beginTransaction();
        try {
            $update_model = $this->model::findOrFail($this->user_id);
            $update_model->update($validated);
            DB::commit();
            $this->alert('success', 'Updated Successfully');
            $this->resetInputFields();
        } catch (\Exception $e) {
            DB::rollback();
            $this->alert('error', 'Wrong update' . $e);
            $this->resetInputFields();
        }
    }
    // delete method
    // public function delete($id)
    // {
    //     $this->alert_delete('warning', '? Are you sure', $id);
    // }
    // destroy method
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
          //  $id   = un_hash_id($id);
            $delete_model = $this->model::findOrFail($id);
            $delete_model->delete();
            DB::commit();
            $this->alert('success', 'Deleted Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            $this->alert('error', 'Wrong delete' . $e);
        }
    }
    // delete ids
    public function deleteIDS()
    {
        if (!empty($this->Ids)) {
            foreach ($this->Ids as $key => $value) {
                $array_delete_ids[] = un_hash_id($value);
            }
            $this->Ids = $array_delete_ids;
            try {
                $delete_model = $this->model::whereIn('id', $this->Ids)->delete();
                DB::commit();
                $this->alert('success', 'Deleted Successfully');
                $this->Ids = [];
            } catch (\Exception $e) {
                DB::rollback();
                $this->alert('error', 'Wrong delete' . $e);
            }
        } else {
            $this->alert('error', 'Please Check id');
        }
    }
    // restore id
    public function restore($id)
    {
        DB::beginTransaction();
        try {
           // $id   = un_hash_id($id);
            $restore_model = $this->model::withTrashed()->findOrFail($id)->restore();
            DB::commit();
            $this->alert('success', 'Restore Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            $this->alert('error', 'Wrong restore' . $e);
        }
    }
    // restore ids
    public function restoreIDS()
    {
        DB::beginTransaction();
        try {
            $restore_model = $this->model::onlyTrashed()->restore();
            DB::commit();
            $this->alert('success', 'Restore Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            $this->alert('error', 'Wrong restore' . $e);
        }
    }
    //  switch method
    public function switch($id)
    {
        //$id   = un_hash_id($id);
        try {
            $switch_model = $this->model::findOrFail($id);
            if ($switch_model->status == 1) {
                $switch_model->update(['status' => 0]);
            }else {
                $switch_model->update(['status' => 1]);
            }
            $this->alert('sucess', 'Status Update Successfully');
        } catch (\Exception $e) {
            $this->alert('error', 'Wrong ID');
        }
    }
    // EXCEL
    public function EXCEL()
    {
        try {
            $excel_path = storage_path() . "/app/public/excel";
            if (!is_dir($excel_path)) {
                $files = mkdir($excel_path, 0777, true);
            }

            (new FastExcel(Task::all()))->export('file.xlsx');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    // render
    public function render()
    {
        // check if entries is valid numeric 
        if (!is_numeric($this->entries) || $this->entries < 1)
            $this->entries = 10;

        //Only_Trashed
        if ($this->Only_Trashed) {
            $Model = $this->model::onlyTrashed()->where($this->SearchInColumn, 'LIKE', '%' . $this->search . '%')->paginate($this->entries);

            //With_Trashed
        } elseif ($this->With_Trashed) {
            $Model = $this->model::withTrashed()->where($this->SearchInColumn, 'LIKE', '%' . $this->search . '%')->paginate($this->entries);

            //Completed
        } elseif ($this->Completed) {
            $Model = $this->model::Completed()->where($this->SearchInColumn, 'LIKE', '%' . $this->search . '%')->paginate($this->entries);

            // DateFrom
        } elseif ($this->DateFrom) {
            $date = Carbon::now()->subDays($this->DateFrom);
            $Model = $this->model::where('created_at', '>=', $date)->where($this->SearchInColumn, 'LIKE', '%' . $this->search . '%')->paginate($this->entries);

            // Today
        } elseif ($this->Today) {
            $Model = $this->model::where('created_at', 'Like', "%" . Carbon::today()->format('Y-m-d') . "%")->where($this->SearchInColumn, 'LIKE', '%' . $this->search . '%')->paginate($this->entries);

            // Default query
        } else {
            $Model = $this->model::where($this->SearchInColumn, 'LIKE', '%' . $this->search . '%')->paginate($this->entries);
        }
        return view('livewire.' . $this->view, compact('Model'));
    }
}
