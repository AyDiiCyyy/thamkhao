<?php

namespace App\Repositories\Products\Interface;

interface ProductInterface
{
    public function index($request);
    public function store($request);
    public function edit($id);
    public function update($request, $id);
    public function delete($id);
    public function changeOrder($request);
    public function changeHot($request);
    public function changeActive($request);
    public function getAllCategory();
    public function getAllLanguage();
    public function getAllCategoryEdit($id);
    public function getCateByPro($id);
    public function destroyImage($id);
}
