<?php
 
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
 
class Master_category extends BaseController
{
    /*model*/
    protected $M_master_category;
    /*db*/
    protected $db;
    use ResponseTrait;
     
    public function __construct()
    {
        $this->mdl = new \App\Models\M_master_category();
        $this->validation = \Config\Services::validation();
        $this->db = \Config\Database::connect();
    }
 
    public function index()
    {
        $data = $this->mdl->findAll();
        return $this->respond($data, 200);
    }
 
    // get single show
    public function show($id = null)
    {
        $data = $this->mdl->findById($id);
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('No Data Found with id '.$id);
        }
    }
 
    // create a data
    public function create()
    {
        $kode_kategori = $this->request->getPost('kode_kategori');
        $nama_kategori = $this->request->getPost('nama_kategori');
        $data = [
            'kode_kategori' => $kode_kategori,
            'nama_kategori' => $nama_kategori
        ];
        $validate = $this->validation->run($data, 'create_master_category');
        $errors = $this->validation->getErrors();
 
        if($errors){
            return $this->fail($errors);
        }
 
        $this->mdl->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data Saved'
            ]
        ];
          
        return $this->respondCreated($data, 201);
    }
 
    // update a data
    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $data['id'] = $id;
        $validate = $this->validation->run($data, 'update_master_category');
        $errors = $this->validation->getErrors();
 
        if($errors){
            return $this->fail($errors);
        }
 
        if(!$this->mdl->findById($id))
        {
            return $this->fail('id tidak ditemukan');
        }
 
        $this->mdl->update($id, $data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data Updated'
            ]
        ];
        return $this->respond($response);
    }
 
    // delete a data
    public function delete($id = null)
    {
        if(!$this->mdl->findById($id))
        {
            return $this->fail('id tidak ditemukan');
        }
 
        if($this->mdl->delete($id)){
            return $this->respondDeleted(['id'=>$id.' Deleted']);
        }
    }
}