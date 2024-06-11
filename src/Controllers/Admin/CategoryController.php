<?php

namespace Duchuy\Php2\Controllers\Admin;

use Exception;
use Duchuy\Php2\Commons\Controller;
use Duchuy\Php2\Commons\Helper;
use Duchuy\Php2\Models\Category;
use Rakit\Validation\Validator;

class CategoryController extends Controller
{
    private Category $categories;

    public function __construct()
    {
        $this->categories = new Category();
    }

    public function index()
    {
        $title = 'List Categories';

        $categories = $this->categories->all();

        $this->renderViewAdmin('categories.index', [
            'title' => $title,
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $title = 'Create Category';
        $this->renderViewAdmin('categories.create', ['title' => $title]);
    }

    public function store()
    {
        try {
            $validator = new Validator();

            $validation = $validator->make($_POST, [
                'name' => 'required|min:3|max:100|regex:/^[\p{L} ]+$/u',
            ]);

            $validation->validate();

            if ($validation->fails()) {

                $_SESSION['data'] = $_POST;

                $_SESSION['errors'] = $validation->errors()->firstOfAll();

                throw new Exception('Có lỗi xảy ra vui lòng thử lại');
            } else {

                $data = [
                    'name' => $_POST['name'] ?? null,
                ];

                if ($data) {

                    $this->categories->insert($data);
                    $_SESSION['status'] = true;
                    $_SESSION['msg'] = 'Thao tác thành công';
                    header('Location: ' . url('admin/categories'));
                    exit();
                }
            }
        } catch (\Throwable $th) {

            $_SESSION['status'] = false;
            $_SESSION['msg'] = $th->getMessage();
            header('Location: ' . url('admin/categories/create'));
        }
    }

    // public function show($id)
    // {
    //     try {

    //         $title = 'Category Details';

    //         $category = $this->categories->findById($id);

    //         if (empty($category)) {
    //             throw new Exception('Không tìm thấy danh mục');
    //         }

    //         $this->renderViewAdmin('categories.show', compact('title', 'category'));
    //     } catch (\Throwable $th) {

    //         $_SESSION['status'] = false;
    //         $_SESSION['msg'] = $th->getMessage();

    //         header('Location: ' . url('admin/categories'));

    //         die;
    //     }
    // }

    public function edit($id)
    {
        try {
            $title = 'Update Category';

            $category = $this->categories->findById($id);

            if (empty($category)) {
                throw new Exception('Không tìm thấy danh mục');
            }

            $this->renderViewAdmin('categories.edit', compact('title', 'category'));
        } catch (\Throwable $th) {

            $_SESSION['status'] = false;
            $_SESSION['msg'] = $th->getMessage();

            header('Location: ' . url('admin/categories'));

            die;
        }
    }

    public function update($id)
    {
        try {
            $category = $this->categories->findById($id);

            if (empty($category)) {
                throw new Exception('Không tìm thấy danh mục');
            }

            $validator = new Validator();

            $validation = $validator->make($_POST, [
                'name' => 'required|min:3|max:100|regex:/^[\p{L} ]+$/u',
            ]);

            $validation->validate();

            if ($validation->fails()) {

                $_SESSION['errors'] = $validation->errors()->firstOfAll();
                throw new Exception('Có lỗi xảy ra, vui lòng thử lại');
            } else {

                $data = [
                    'name' => $_POST['name'] ?? $category['name'],
                ];
                // Helper::debug($data);
                if ($data) {

                    $this->categories->update($id, $data);
                    $_SESSION['status'] = true;
                    $_SESSION['msg'] = 'Thao tác thành công';
                    header('Location: ' . url("admin/categories/{$category['id']}/edit"));

                    exit();
                }
            }
        } catch (\Throwable $th) {

            $_SESSION['status'] = false;
            $_SESSION['msg'] = $th->getMessage();
            header('Location: ' . url("admin/categories/{$category['id']}/edit"));
        }
    }

    public function delete($id)
    {
        try {
            $category = $this->categories->findById($id);

            if (!empty($category)) {
                $this->categories->delete($id);
            }

            $_SESSION['status'] = true;
            $_SESSION['msg'] = 'Thao tác thành công';
            header('Location: ' . url('admin/categories'));
        } catch (\Throwable $th) {

            $_SESSION['status'] = false;
            $_SESSION['msg'] = $th->getMessage();
            header('Location: ' . url('admin/categories'));
        }
    }
}
