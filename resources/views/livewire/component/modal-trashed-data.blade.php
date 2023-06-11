<div>
  <div wire:ignore.self class="modal fade" id="trashed-{{ $model }}-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="trashed-{{ $model }}-modal" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content" style="background-clip: border-box !important;">
        <div class="modal-header" wire:click="$refresh">
          <h5 class="modal-title" id="trashed-{{ $model }}-modal"><i class="fas fa-trash fa-xs text-danger"></i> &ensp; {{ $modalTitle }} </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-0 text-xs table-responsive">
          <table class="table table-head-fixed table-hover m-0" style="min-width: 600px !important;">
            <thead>
              <tr>
                <th class="align-middle btw-1 text-center" width="10%" style="padding: 0.75rem !important;">No.</th>
                @foreach ($field as $key => $item)
                  <th class="{{ $item['th_class'] }}">{{ $item['th'] }}</th>
                @endforeach
                <th class="align-middle btw-1 text-center" width="20%" style="padding: 0.75rem !important;">#</th>
              </tr>
            </thead>
            <tbody id="trashed-post-data">
              <tr>
                <td class="bg-secondary" colspan="{{ count($field) + 2 }}" style="padding: 1px;"></td>
              </tr>
              @forelse ($dataTrashed as $key => $item)
                <tr>
                  <td class="align-middle font-weight-bold text-center" style="padding: 0.75rem !important;">{{ ($dataTrashed->currentpage()-1) * $dataTrashed->perpage() + $loop->index + 1 }}.</td>
                  @foreach ($field as $item2)
                    <td class="{{ $item2['td_class'] }}">
                      @switch($item2['type'])
                        @case('string')
                          {{ $item->toArray()[$item2['field_name']] }}
                          @break
                        @case('date')
                          {{ date('d/m/Y H:i:s', strtotime($item->toArray()[$item2['field_name']])) }}
                          @break
                        @default
                          -
                      @endswitch
                    </td>
                  @endforeach
                  <td class="align-middle font-weight-bold text-center" style="padding: 0.75rem !important;">
                    <div class="btn-group">
                      <button class="btn btn-xs btn-info" wire:click="$emitUp('restoreData', {{ $item->id }})">
                        <span class="fa fa-undo"></span> Pulihkan Data
                      </button>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td class="text-center" colspan="{{ count($field) + 2 }}">Belum Ada Data</td>
                </tr>
              @endforelse
              <tr>
                <td class="bg-secondary" colspan="{{ count($field) + 2 }}" style="padding: 1px;"></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer text-sm">
          {{ is_array($dataTrashed) ? '' : $dataTrashed->links() }}
        </div>
      </div>
    </div>
  </div>
  {{-- Do your work, then step back. --}}
</div>


@push('css')
<style>
  .pagination {
    margin: 0px !important;
  }
</style>
@endpush

@push('script')
<script>
  $(document).ready(function () {
    Livewire.on('modal-trashed-' + '{{ $model }}', function(val) {
      $('#trashed-{{ $model }}-modal').modal(val);
    });
  });
</script>
@endpush
