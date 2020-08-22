<?php

namespace App\Repositories\Admin\Category;

interface CategoryRepositoryInterface
{
	public function all();

	public function store(array $categoryData);

	public function find($id);

	public function destroy($id);

	public function update($category, array $categoryData);	

	public function massDelete(array $categoryIds);
}