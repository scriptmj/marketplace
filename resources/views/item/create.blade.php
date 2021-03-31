<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Advertise new item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Content -->

<div class="mt-10 sm:mt-0">
  <div class="md:grid md:grid-cols-4 md:gap-6">
    <div class="md:col-span-1">
      <div class="px-4 sm:px-0">
        <h3 class="text-lg font-medium leading-6 text-gray-900">New item</h3>
        <p class="mt-1 text-sm text-gray-600">
          
        </p>
      </div>
    </div>
    <div class="mt-5 md:mt-0 md:col-span-3">
      <form action="{{route('item.store')}}" method="POST" enctype="multipart/form-data">
      @csrf
        <div class="shadow overflow-hidden sm:rounded-md">
          <div class="px-4 py-5 bg-white sm:p-6">
            <div class="grid grid-cols-6 gap-6">

            <!-- Item name -->
              <div class="col-span-6 sm:col-span-3">
                <label for="item_name" class="block text-sm font-medium text-gray-700">Item name</label>
                <input 
                    type="text" 
                    name="item_name" 
                    id="item_name" 
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    value= "{{old('item_name')}}">
                @error('item_name')
            <p class="help-block">{{$errors->first('item_name')}}</p>
        @enderror
              </div>

            <!-- Short description -->
              <div class="col-span-6 sm:col-span-6">
              <label for="short_description" class="block text-sm font-medium text-gray-700">
                Short description
              </label>
              <div class="mt-1">
                <textarea 
                    id="short_description" 
                    name="short_description" 
                    rows="2" 
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md">{{old('short_description')}}</textarea>
              </div>
              <p class="mt-2 text-sm text-gray-500">
                This description will be shown on the homepage.
              </p>
              @error('short_description')
            <p class="help-block">{{$errors->first('short_description')}}</p>
        @enderror
                </div>

            <!-- Long description -->
                <div class="col-span-6 sm:col-span-6">
              <label for="long_description" class="block text-sm font-medium text-gray-700">
                Full description
              </label>
              <div class="mt-1">
                <textarea 
                id="long_description" 
                name="long_description" 
                rows="5" 
                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md">{{old('long_description')}}</textarea>
              </div>
              <p class="mt-2 text-sm text-gray-500">
                Describe the item with all necessary details.
              </p>
              @error('long_description')
            <p class="help-block">{{$errors->first('long_description')}}</p>
        @enderror
                </div>

            <!-- Minimum bid -->
            <div class="col-span-6 sm:col-span-6">
              <label for="minimum_bid" class="block text-sm font-medium text-gray-700">
                Minimum bid
              </label>
              <div class="col-span-6 sm:col-span-3">
                €<input 
                type="number" step="0.01"
                id="minimum_bid" 
                name="minimum_bid" 
                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md"
                value="{{old('minimum_bid')}}">
              </div>
              <p class="mt-2 text-sm text-gray-500">
                Leave blank is no minimum is required.
              </p>
              @error('minimum_bid')
            <p class="help-block">{{$errors->first('minimum_bid')}}</p>
        @enderror
                </div>

            <!-- Image upload -->
                <div class="col-span-6 sm:col-span-6">
              <label for="image" class="block text-sm font-medium text-gray-700">
                Item photo
              </label>
              <div>
        <input type="file" 
        class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        id="image" name="image">

        @error('image')
            <p class="help-block">{{$errors->first('image')}}</p>
        @enderror
    </div>
    <!-- Image preview -->
    <img id="preview-image-before-upload" style="width:400px;height:200px;margin:5px;"></img>

    <!-- Categories selection -->
    <div class="col-span-6 sm:col-span-6">
      <label for="categoriesDiv" class="block text-sm font-medium text-gray-700">
        Categories
      </label>
      <div class="block text-sm font-medium text-gray-700 m-2" id="categoriesDiv"></div>

    <!-- Categories selection for form HIDDEN -->    
        <select style="display:none" name="categories[]" id="categoriesInput" multiple></select>

    <!-- Category choices -->
        <div id="category-choices">
            @foreach($categories as $category)
              <button id="cat {{$category->id}}" type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" onClick="addCategory('{{$category->id}}', '{{$category->name}}')">{{$category->name}}</button>
            @endforeach
            @error('categories')
              <p class="help-block">{{$errors->first('categories')}}</p>
            @enderror
        </div>
  </div>
    <!-- Adding new custom category -->
        <div>
            <div class="col-span-6 sm:col-span-6">
                <label for="add-category" class="inline-flex text-sm font-medium text-gray-700">New category: </label>
                <input type="text" id="add-category-input" name="add-category" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md">
                <button type="button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" onclick="addNewCategory()">+</button>
            </div>
        </div>
            </div>
          </div>

<!-- Submit -->
          <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Save
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

                    <!-- End content -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="../../js/image-upload.js"></script>