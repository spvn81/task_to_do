<?php

namespace App\Controllers;
use CodeIgniter\Database\RawSql;


class Home extends BaseController
{
    private $db;


    public function __construct()
    {

        $this->db = \Config\Database::connect();
}



    public function index(): string
    {
        $builder = $this->db->table('to_do_list');
        $data['tasks'] = $builder->get()->getResult();

        return view('index',$data);
    }


    public function addOrUpdateToDoData(){
        $request = \Config\Services::request();
         $title = $request->getPost('title'); 
         $details = $request->getPost('details'); 
         $date = $request->getPost('date'); 
        $builder = $this->db->table('to_do_list');
        $id = $request->getPost('id'); 
        $data=[
            'title'=>$title,
            'details'=>$details,
            'date'=>$date,
        ];

        if(empty($id)){
         
            if($builder->insert($data)){
                return $this->response->setJSON(['status'=>'ok','message'=>'data inserted success']);
    
            }else{
                return $this->response->setJSON(['status'=>'nok','message'=>'data inserted failed']);
    
            }
        }else{

         $to_do_list_update =    $builder->where('id', $id)->update($data);
         if($to_do_list_update){
            return $this->response->setJSON(['status' => 'ok', 'message' => 'Task updated successfully']);

         }else{
            return $this->response->setJSON(['status'=>'nok','message'=>'data updated failed']);

         }


        }
     
 

      
    }

    public function getToDoListById(){
        $request = \Config\Services::request();
        $id = $request->getPost('id'); 
        $builder = $this->db->table('to_do_list');
        $to_do_list = $builder->where('id', $id)
        ->get()
        ->getRow();
        if(!empty($to_do_list)){
            return $this->response->setJSON(['status'=>'ok','data'=>$to_do_list]);

        }else{
            return $this->response->setJSON(['status'=>'nok','message'=>'data not found']);

        }


    }

    public function deleteToDoData()
    {
        $request = \Config\Services::request();
        $id = $request->getPost('id');
        $builder = $this->db->table('to_do_list');
        $builder->where('id', $id)->delete();
        return $this->response->setJSON(['status' => 'ok', 'message' => 'Task deleted successfully']);
    }




}
