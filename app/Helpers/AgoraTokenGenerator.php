<?php

namespace App\Helpers;

class AgoraTokenGenerator
{
    public static function createToken(string $channelName, int $uid): string
    {
        $appId = env('AGORA_APP_ID');
        $appCertificate = env('AGORA_APP_CERTIFICATE');

        $role = RtcTokenBuilder::RoleAttendee;

        $ttl = 3600;
        $issuedAt = now()->timestamp;
        $expirationTime = $issuedAt + $ttl;

        return RtcTokenBuilder::buildTokenWithUid(
            $appId,
            $appCertificate,
            $channelName,
            $uid,
            $role,
            $expirationTime
        );
    }
}
