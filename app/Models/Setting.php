<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    
    protected $fillable  = ['name','payment_ref_auto','payment_date_position',
    'payment_size','payment_next_ref','payment_prefix'];
    protected $table = 'settings';
    use HasFactory;
    public function getReferenceInfos($dbRefAutoFieldName)
	{
		$referenceParameterFields =Setting::where([
                                [$dbRefAutoFieldName,'=',1],
                                ['name','=','reference']
                                ])
                                ->first();

		return $referenceParameterFields;
	}
    static public function getNextReferenceByFieldName($dbFieldName)
    {
        $date = Date('Y');
        $referenceParameterFields =Setting::getReferenceInfos($dbFieldName.'_ref_auto');
        $dbFieldNameSize = $dbFieldName.'_size';
        $dbFieldNamePrefix = $dbFieldName.'_prefix';
        $dbFieldNameDatePosition = $dbFieldName.'date_position';
        $dbFieldNameNextref = $dbFieldName.'_next_ref';
        if (!empty ($referenceParameterFields)) {
            $size = (int)$referenceParameterFields->$dbFieldNameSize;
            $prefix = $referenceParameterFields->$dbFieldNamePrefix;
			$datePosition = $referenceParameterFields->$dbFieldNameDatePosition;
            $nextNumber = $referenceParameterFields-> $dbFieldNameNextref;
            $sizeNumber = strlen((int)$nextNumber);
            $nextReference = '';
            if ($size > $sizeNumber) {
                $size = $size - $sizeNumber;
                $nextReference = $nextNumber;
                for ($i = 1; $i <= $size; $i++) {
                    $nextReference = '0' . $nextReference;
                }
            } else {
                $nextReference = $nextNumber;
            }
			if ($datePosition == 2) {
                $nextReference = $prefix . $nextReference. '/' . $date  ;
            } else {
				$nextReference = $date. '/' .$prefix . $nextReference;
			}
            
            return $nextReference;
        } else {
            return 0;
        }
    }

    static public function setNextReferenceNumber($dbFieldName){
        $nextNumber = 0;
        $referenceParameterFields =Setting::getReferenceInfos($dbFieldName.'_ref_auto');
        $dbFieldNameNextref = $dbFieldName.'_next_ref';
        if (!empty ($referenceParameterFields)) {
                    $number = $referenceParameterFields->$dbFieldNameNextref;
                    $nextNumber = (int)$number+1;
                    Setting::where('id', $referenceParameterFields->id)
                    ->update(array($dbFieldName.'_next_ref' => $nextNumber));
                }
                return $nextNumber;
	}
}
