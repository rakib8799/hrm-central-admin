<?php

namespace App\Services;

use App\Models\Country;
use App\Models\Configuration;
use Illuminate\Support\Facades\DB;

class ConfigurationService extends BaseModelService
{   
    public function model(): string
    {
        return Configuration::class;
    }

    public function getCompanyPublicConfiguration()
    {
        $configurations = $this->model()::all();
        $mergedConfiguration = collect();

        // Transform each configuration item
        $configurations->each(function ($configuration) use ($mergedConfiguration) {
            if($configuration->option_name === 'country_id') {
                $country = Country::find($configuration->option_value);
                $countryName = $country ? $country->name : null;

                $mergedConfiguration->put('country_id', $configuration->option_value);
                $mergedConfiguration->put('country_name', $countryName);
            } else {
                if ($configuration->option_name === 'weekends') {
                    $configuration->option_value = json_decode($configuration->option_value, true);
                } else if ($configuration->option_name === 'is_roster') {
                    $configuration->option_value = $configuration->option_value == '1' ? 1 : 0;
                }

                $mergedConfiguration->put($configuration->option_name, $configuration->option_value);
            }
        });

        return (object) $mergedConfiguration;
    }

    public function updateConfiguration($validatedData)
    {
        $result = DB::transaction(function() use ($validatedData) {
            $configurations = Configuration::whereIn('option_name', array_keys($validatedData))->get();
            foreach ($configurations as $configuration) {
                $optionName = $configuration->option_name;
                $configuration->option_value = $validatedData[$optionName];
                $configuration->save();
            }
            return true;
        });
        return $result;
    }

    public function getConfiguration($optionName)
    {
        return $this->model()::where('option_name', $optionName)->first();
    }

    public function getSupportDetails()
    {
        $supportEmail = $this->getConfiguration('support_email')->option_value;
        $supportTelephone = $this->getConfiguration('support_telephone')->option_value;
        $responseData = [
            'supportEmail' => $supportEmail, 
            'supportTelephone' => $supportTelephone
        ];
        return $responseData;
    }
}
