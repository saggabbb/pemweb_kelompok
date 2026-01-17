<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manage Categories') }}
            </h2>
            <button x-data @click="$dispatch('open-modal', 'create-category')" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">
                + Add Category
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($categories as $category)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $category->category_name }}</td>
                                        <td class="px-6 py-4">{{ Str::limit($category->description, 50) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $category->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($category->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button 
                                                x-data
                                                @click="$dispatch('open-modal', 'edit-category-{{ $category->id }}')" 
                                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600 mr-3"
                                            >
                                                Edit
                                            </button>
                                            
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600">Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <x-modal name="edit-category-{{ $category->id }}" :show="$errors->hasBag('updateCategory' . $category->id)" focusable>
                                        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="p-6">
                                            @csrf
                                            @method('PUT')
        
                                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                {{ __('Edit Category') }}
                                            </h2>
        
                                            <div class="mt-6">
                                                <x-input-label for="category_name" value="{{ __('Name') }}" />
                                                <x-text-input id="category_name" name="category_name" type="text" class="mt-1 block w-full" :value="old('category_name', $category->category_name)" required autofocus />
                                                <x-input-error class="mt-2" :messages="$errors->get('category_name')" />
                                            </div>
        
                                            <div class="mt-6">
                                                <x-input-label for="description" value="{{ __('Description') }}" />
                                                <textarea id="description" name="description" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" rows="3" required>{{ old('description', $category->description) }}</textarea>
                                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                                            </div>

                                            <div class="mt-6">
                                                <x-input-label for="status" value="{{ __('Status') }}" />
                                                <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                                    <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>
        
                                            <div class="mt-6 flex justify-end">
                                                <x-secondary-button x-on:click="$dispatch('close')">
                                                    {{ __('Cancel') }}
                                                </x-secondary-button>
        
                                                <x-primary-button class="ml-3">
                                                    {{ __('Update Category') }}
                                                </x-primary-button>
                                            </div>
                                        </form>
                                    </x-modal>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                     <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <x-modal name="create-category" :show="$errors->hasBag('createCategory')" focusable>
        <form method="POST" action="{{ route('admin.categories.store') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Create New Category') }}
            </h2>

            <div class="mt-6">
                <x-input-label for="new_category_name" value="{{ __('Name') }}" />
                <x-text-input id="new_category_name" name="category_name" type="text" class="mt-1 block w-full" :value="old('category_name')" required placeholder="e.g. Electronics" />
                <x-input-error class="mt-2" :messages="$errors->get('category_name')" />
            </div>

            <div class="mt-6">
                <x-input-label for="new_description" value="{{ __('Description') }}" />
                <textarea id="new_description" name="description" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" rows="3" required placeholder="Description...">{{ old('description') }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('description')" />
            </div>

            <div class="mt-6">
                 <x-input-label for="new_status" value="{{ __('Status') }}" />
                 <select id="new_status" name="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ml-3">
                    {{ __('Save Category') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
