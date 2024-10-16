<?php

namespace App\Repositories\CategoryProducts\Interface;

interface CategoryProductInterface
{
    public function index($request);
    public function store($request);
    public function edit($id);
    public function update($request, $id);
    public function delete($id);
    public function changeOrder($request);
    public function changeHot($request);
    public function changeActive($request);
    public function getAllLanguage();
    public function getAllCategory();
    public function getAllCategoryEdit($id);
    
}
