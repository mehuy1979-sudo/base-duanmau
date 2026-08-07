class ProductModel extends BaseModel
{
    protected $table = "products";

    public function getAll()
    {
        return $this->all();
    }

    public function getOne($id)
    {
        return $this->find($id);
    }

    public function insert($data)
    {
        return $this->create($data);
    }

    public function updateProduct($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteProduct($id)
    {
        return $this->delete($id);
    }
}