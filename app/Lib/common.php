<?php 
namespace App\Lib;

use Session;
use DB;

class common {

	public function getRole($type){
    	$role = '';

    	switch ($type) {
    		case 'pa05':
    			
	            $roles=DB::table('pa05_member')
	            ->where([
	                ['member_id', '=', session('User')]
	            ])
	            ->get();
	            if (count($roles)>0){
	               $role = $roles->first()->role;
	            }

    			break;

    		case 'contract':
    			$roles=DB::table('contract_member')
	            ->where([
	                ['member_id', '=', session('User')]
	            ])
	            ->get();
	            if (count($roles)>0){
	               $role = $roles->first()->role;
	            }

    			break;
    		
    		default:
    			# code...
    			$role = '';
    			break;
    	}

    	return $role;
  
	}

	public function getSysConfig(){
		return DB::table('sys_config')->first();
	}

	public function getCurrentSessionUser(){
		return DB::table('sys_account')
        ->where([
            ['userid', '=', session('User')]
        ])
        ->first();
	}

}