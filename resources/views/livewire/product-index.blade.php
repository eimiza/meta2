<div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="flex flex-col gap-6">
        <div class="rounded-xl border">
            <br>
            <flux:heading class="px-10" size="xl">{{ $productID ? 'Edit Product' : 'Add Product' }}</flux:heading>
            <div class="px-10 py-8">
                <form wire:submit.prevent="save" class="space-y-4 mb-6">
                    <div class="grid grid-col-2 gap-4">
                        <flux:input wire:model="name" label="Product Name" placeholder="Product Name" />
                        <flux:textarea wire:model="description" label="Description" placeholder="Description" />
                        <flux:input wire:model="price" label="price" placeholder="Price" />
                        <flux:button type="submit" variant="primary">Submit</flux:button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>
    <div class="flex flex-col gap-6">
        <div class="text-center text-green-600 p-5">{{ session('message') }}</div>
        <div class="rounded-xl border">
            <div class="px-10 py-8">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $index => $p)
                        <tr>
                            <td class="text-center p-2">{{ $index+1 }}</td>
                            <td class="p-2">{{ $p->name }}</td>
                            <td style="min-width: 700px;">{{ $p->description }}</td>
                            <td class="text-center">{{ $p->price }}</td>
                            <td class="p-2">
                                <flux:button wire:click="edit({{ $p->id }})" icon="pencil" variant="primary"></flux:button>
                                <flux:button wire:click="$dispatch('confirmDelete', {{ $p->id }})" icon="trash" variant="danger"></flux:button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center p-2">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('livewire:init', function(){
        Livewire.on('productSaved', function(res){
            Swal.fire('Success!', res.message, 'success');
        });
        Livewire.on('confirmDelete', function(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('delete', {id: id});
                }
            });
        });
    });
</script>