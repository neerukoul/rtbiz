<?php

/**
 * Don't load this file directly!
 */
if ( ! defined( 'ABSPATH' ) )
	exit;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of class-rt-user-groups-relationships-model
 *
 * @author udit
 */
if ( ! class_exists( 'RT_User_Group_Relationships_Model' ) ) {

	class RT_User_Group_Relationships_Model extends RT_DB_Model {

		public function __construct() {
			parent::__construct( 'rt_user_group_relationships' );
		}

	}

}