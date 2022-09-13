<?php
namespace App\Models;
 
use CodeIgniter\Model;
use Exception;
 
class M_master_category extends Model
{
    protected $table = 't_category';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kode_kategori','nama_kategori'];
    protected $useTimestamps = false;
 
    public function findById($id)
    {
        $data = $this->find($id);
        if($data)
        {
            return $data;
        }
        return false;
    }
}