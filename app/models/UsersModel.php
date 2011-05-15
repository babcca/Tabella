<?php
	class UsersModel extends \Nette\Object {
		const db_name = 'users';
		
		public static function dataSource() {
			return dibi::dataSource( "SELECT *, (daughters + sons) as children FROM %n", self::db_name );
		}
		
		public static function save( $set, $id = 0) {
			if( $id == 0 )
				dibi::query( "INSERT INTO %n", self::db_name, $set );
			else
				dibi::query( "UPDATE %n", self::db_name, " SET ", $set, "WHERE id = %i", $id );
		}
		
		public static function delete( $id ) {
			dibi::query( "DELETE FROM %n", self::db_name, " WHERE id = %i", $id );
		}
	}
