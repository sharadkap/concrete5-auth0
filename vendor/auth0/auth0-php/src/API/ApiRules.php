<?php

namespace Auth0\SDK\API;

use Auth0\SDK\API\ApiClient;
use Auth0\SDK\API\Header\Authorization\AuthorizationBearer;
use Auth0\SDK\API\Header\ContentType;

class ApiRules {

    protected static function getApiV2Client($domain) {

        $apiDomain = "https://$domain";

        $client = new ApiClient(array(
            'domain' => $apiDomain,
            'basePath' => '/api/v2',
        ));
        return $client;
    }

    public static function getAll($domain, $token, $enabled = null, $fields = null, $include_fields = null) {

        $request = self::getApiV2Client($domain)->get()
            ->rules()
            ->withHeader(new AuthorizationBearer($token));

        if ($enabled !== null) {
            $request->withParam('enabled', $enabled);
        }
        if ($fields !== null) {
            if (is_array($fields)) {
                $fields = implode(',', $fields);
            }
            $request->withParam('fields', $fields);
        }
        if ($include_fields !== null) {
            $request->withParam('include_fields', $include_fields);
        }

        $info = $request->call();

        return $info;
    }

    public static function get($domain, $token, $id, $fields = null, $include_fields = null) {

        $request = self::getApiV2Client($domain)->get()
            ->rules($id)
            ->withHeader(new AuthorizationBearer($token));

        if ($fields !== null) {
            if (is_array($fields)) {
                $fields = implode(',', $fields);
            }
            $request->withParam('fields', $fields);
        }
        if ($include_fields !== null) {
            $request->withParam('include_fields', $include_fields);
        }

        $info = $request->call();

        return $info;
    }

    public static function delete($domain, $token, $id) {

        $request = self::getApiV2Client($domain)->delete()
            ->rules($id)
            ->withHeader(new AuthorizationBearer($token))
            ->call();
    }

    public static function create($domain, $token, $data) {

        $info = self::getApiV2Client($domain)->post()
            ->rules()
            ->withHeader(new AuthorizationBearer($token))
            ->withHeader(new ContentType('application/json'))
            ->withBody(json_encode($data))
            ->call();

        return $info;
    }

    public static function update($domain, $token, $id, $data) {

        $info = self::getApiV2Client($domain)->patch()
            ->rules($id)
            ->withHeader(new AuthorizationBearer($token))
            ->withHeader(new ContentType('application/json'))
            ->withBody(json_encode($data))
            ->call();

        return $info;
    }

}
