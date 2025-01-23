@extends('layouts.layoutMaster')

@section('title', 'Manage Fees - UNISSA Financial Management System')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'
])
@endsection

@section('page-script')
@vite('resources/assets/js/app-invoice-list.js')
@endsection

@section('page-style')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <h2><strong>Fee Categories</strong></h2>
    <hr>

    <!-- Add Category Button -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
        Add Fee Category
    </button>

    <!-- Success Messages -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Categories Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Category Name</th>
                <th>Category Code</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $index => $category)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $category->fee_category_name }}</td>
                    <td>{{ $category->fee_category_code }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->fee_category_id }}">
                            Edit
                        </button>

                        <!-- Delete Button -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal{{ $category->fee_category_id }}">
                            Delete
                        </button>

                        <a href="{{ route('fee-rules.index', $category->fee_category_id) }}" class="btn btn-sm btn-info">Manage Rules</a>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editCategoryModal{{ $category->fee_category_id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel{{ $category->fee_category_id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('fee-categories.update', $category->fee_category_id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editCategoryModalLabel{{ $category->fee_category_id }}">Edit Fee Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="fee_category_name" class="form-label">Category Name</label>
                                        <input type="text" class="form-control @error('fee_category_name') is-invalid @enderror" id="fee_category_name" name="fee_category_name" value="{{ old('fee_category_name', $category->fee_category_name) }}" required>
                                        @error('fee_category_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="fee_category_code" class="form-label">Category Code</label>
                                        <input type="text" class="form-control @error('fee_category_code') is-invalid @enderror" id="fee_category_code" name="fee_category_code" value="{{ old('fee_category_code', $category->fee_category_code) }}" required>
                                        @error('fee_category_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteCategoryModal{{ $category->fee_category_id }}" tabindex="-1" aria-labelledby="deleteCategoryModalLabel{{ $category->fee_category_id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('fee-categories.delete', $category->fee_category_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteCategoryModalLabel{{ $category->fee_category_id }}">Delete Fee Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete the category "{{ $category->fee_category_name }}"?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No fee categories available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('fee-categories.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add Fee Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fee_category_name" class="form-label">Category Name</label>
                        <input type="text" class="form-control @error('fee_category_name') is-invalid @enderror" id="fee_category_name" name="fee_category_name" value="{{ old('fee_category_name') }}" required>
                        @error('fee_category_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="fee_category_code" class="form-label">Category Code</label>
                        <input type="text" class="form-control @error('fee_category_code') is-invalid @enderror" id="fee_category_code" name="fee_category_code" value="{{ old('fee_category_code') }}" required>
                        @error('fee_category_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
