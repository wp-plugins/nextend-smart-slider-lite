<?php
/**
* @version 			SEBLOD 2.x Core ~ $Id: field.php sebastienheraud $
* @package			SEBLOD (App Builder & CCK) // SEBLOD nano (Form Builder)
* @url				http://www.seblod.com
* @editor			Octopoos - www.octopoos.com
* @copyright		Copyright (C) 2012 SEBLOD. All Rights Reserved.
* @license 			GNU General Public License version 2 or later; see _LICENSE.php
**/

// No Direct Access
defined( '_JEXEC' ) or die;

// JCckDevField
abstract class JCckDevField
{
	// -------- -------- -------- -------- -------- -------- -------- -------- // Get
	
	// get
	public static function get( $field, $value, &$config = array( 'doTranslation' => 1, 'doValidation' => 2 ), $inherit = array(), $override = array() )
	{
		if ( ! is_object( $field ) ) {
			$field	=	JCckDatabase::loadObject( 'SELECT a.* FROM #__cck_core_fields AS a WHERE a.name = "'.$field.'"' );
			if ( ! $field ) {
				return;
			}
		}
		$field->required_alert		=	'';
		$field->validation_options	=	'';
		$field->variation			=	'';
		$field->access				=	'';
		$field->conditional			=	'';
		$field->conditional_options	=	'';
		if ( count( $override ) ) {
			foreach ( $override as $k => $v ) {
				$field->$k	=	$v;
			}
		}
		if ( ! ( $field && @$field->storage == 'dev' && @$field->storage_field ) ) {
			return '';
		}
		
		$inherit['name']	=	$field->storage_field;
		if ( ! isset( $inherit['id'] ) ) {
			$inherit['id']		=	str_replace( array('[', ']'), array('_', ''), $field->storage_field );
		}
		
		$dispatcher	=	JDispatcher::getInstance();
		$dispatcher->trigger( 'onCCK_FieldPrepareForm', array( &$field, $value, &$config, $inherit ) );
		
		$field->form	=	JCck::callFunc_Array( 'plgCCK_Field'.$field->type, 'onCCK_FieldRenderForm', array( $field, &$config ) );
		
		return $field;
	}
	
	// getAttribute
	public static function getAttribute( $fieldname, $attribute )
	{
		if ( ! $fieldname || ! $attribute ) {
			return false;
		}
		$res	=	JCckDatabase::loadResult( 'SELECT s.'.$attribute.' FROM #__cck_core_fields AS s'
									   .' WHERE s.name="'.$fieldname.'"' );
		
		return $res;
	}
	
	// getForm
	public static function getForm( $field, $value, &$config = array( 'doTranslation' => 1, 'doValidation' => 1, 'client'=>'site', 'pk'=>0 ), $override = array() )
	{
		if ( ! is_object( $field ) ) {
			$field	=	JCckDatabase::loadObject( 'SELECT a.* FROM #__cck_core_fields AS a WHERE a.name = "'.$field.'"' );
			if ( ! $field ) {
				return;
			}
		}
		if ( count( $override ) ) {
			foreach ( $override as $k => $v ) {
				$field->$k	=	$v;
			}
		}
		
		$dispatcher	=	JDispatcher::getInstance();
		$dispatcher->trigger( 'onCCK_FieldPrepareForm', array( &$field, $value, &$config ) );
		
		return JCck::callFunc( 'plgCCK_Field'.$field->type, 'onCCK_FieldRenderForm', $field );
	}
	
	// getObject
	public static function getObject( $fieldname, $attribute = '' )
	{
		if ( ! $fieldname ) {
			return false;
		}
		if ( $attribute ) {
			if ( is_array( $attribute ) ) {
				$req	=	'';
				foreach ( $attribute as $attrib ) {
					if ( $attrib ) {
						$req	.=	'a.'.$attrib.',';
					}
				}
				if ( $req ) {
					$req	=	substr( $req, 0, -1 );
				}
			} else {
				$req	=	'a.'.$attribute;
			}
			$join	=	'';
		} else {
			$req	=	'a.*';
		}
		$res	=	JCckDatabase::loadObject( 'SELECT '.$req.' FROM #__cck_core_fields AS a WHERE a.name="'.$fieldname.'"' );
		
		return $res;
	}
	
	// -------- -------- -------- -------- -------- -------- -------- -------- // Render

	// renderContent
	public static function renderContent( $field, $value = '' )
	{	
		if ( ! is_object( $field ) ) {
			$field	=	JCckDatabase::loadObject( 'SELECT a.* FROM #__cck_core_fields AS a WHERE a.name = "'.$field.'"' );
			if ( ! $field ) {
				return;
			}
		}
		
		require_once JPATH_SITE.DS.'plugins'.DS.'cck_field'.DS.$field->type.DS.$field->type.'.php';
		JCck::callFunc( 'plgCCK_Field'.$field->type, 'onCCK_FieldPrepareContent', $field );
		
		return $field->value;
	}

	// -------- -------- -------- -------- -------- -------- -------- -------- // Stuff
	
	// cleanExtended
	public static function cleanExtended( $fieldname )
	{
		if ( ( $cut = strpos( $fieldname, '[' ) ) !== false ) {
			$res	=	substr( $fieldname, $cut + 1, -1 );
		} elseif ( ( $cut = strpos( $fieldname, '(' ) ) !== false ) {
			$res	=	substr( $fieldname, $cut + 1, -1 );
		} else {
			$res	=	$fieldname;
		}
	
		return $res;
	}
	
	// split
	public static function split( $field, $fieldname, $needle = '[' )
	{
		if ( ( $cut = strpos( $fieldname, $needle ) ) !== false ) {
			$field->$fieldname			=	substr( $fieldname, 0, $cut );
			$field->{$fieldname.'2'}	=	substr( $fieldname, $cut + 1, -1 );			
		} else {
			$field->{$fieldname.'2'}	=	$field->$fieldname;
		}
	}
}
?>