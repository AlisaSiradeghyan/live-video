<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple Video Chat – Agora</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>

    <script>
        const APP_ID = "{{ $appID }}";
        const CHANNEL = "{{ $channel }}";
        const TOKEN = "{{ $token }}";
        const UID = {{ $uid }};
    </script>

    <style>
        .video-area {
            width: 320px;
            height: 240px;
            background: #000;
        }

        button {
            padding: 10px 18px;
            margin: 5px;
            border: none;
            color: #fff;
            border-radius: 4px;
            font-size: 14px;
        }

        #start-btn { background-color: #0077ff; }
        #end-btn { background-color: #e63946; }
        .control-btn { background-color: #555; }
    </style>
</head>
<body style="display:flex; flex-direction:column; align-items:center; justify-content:center; min-height:100vh; background:#eef1f4; font-family:Arial, sans-serif;">

<h2>Live Video Chat</h2>

<div style="display:flex; gap:16px; margin:24px 0;">
    <div id="my-video" class="video-area"></div>
    <div id="other-video" class="video-area"></div>
</div>

<div>
    <button id="start-btn" onclick="startVideo()">Start Call</button>
    <button id="end-btn" onclick="endCall()">Hang Up</button>
    <button id="mic-toggle" class="control-btn" onclick="toggleMicrophone()">Mute</button>
    <button id="cam-toggle" class="control-btn" onclick="toggleCamera()">Turn Camera Off</button>
</div>

<script>
    const agoraClient = AgoraRTC.createClient({ mode: "rtc", codec: "vp8" });
    let tracks = { mic: null, cam: null };
    let micActive = true;
    let camActive = true;

    async function startVideo() {
        if (agoraClient.connectionState === "CONNECTED") {
            console.log("Already in a session.");
            return;
        }

        try {
            await agoraClient.join(APP_ID, CHANNEL, TOKEN, UID);
            [tracks.mic, tracks.cam] = await AgoraRTC.createMicrophoneAndCameraTracks();

            tracks.cam.play("my-video");
            await agoraClient.publish(Object.values(tracks));

            document.getElementById("start-btn").disabled = true;
        } catch (err) {
            console.error("Failed join details:", err);
        }
    }

    function endCall() {
        if (tracks.mic) {
            tracks.mic.stop();
            tracks.mic.close();
        }

        if (tracks.cam) {
            tracks.cam.stop();
            tracks.cam.close();
        }

        agoraClient.leave();

        document.getElementById("my-video").innerHTML = "";
        document.getElementById("other-video").innerHTML = "";
        document.getElementById("start-btn").disabled = false;
    }

    async function toggleMicrophone() {
        if (!tracks.mic) return;

        micActive = !micActive;
        await tracks.mic.setEnabled(micActive);

        document.getElementById("mic-toggle").innerText = micActive ? "Mute" : "Unmute";
    }

    async function toggleCamera() {
        if (!tracks.cam) return;

        camActive = !camActive;
        await tracks.cam.setEnabled(camActive);

        document.getElementById("cam-toggle").innerText = camActive ? "Turn Camera Off" : "Turn Camera On";
    }

    agoraClient.on("user-published", async (remoteUser, mediaType) => {
        await agoraClient.subscribe(remoteUser, mediaType);

        if (mediaType === "video") {
            remoteUser.videoTrack.play("other-video");
        }
    });

    agoraClient.on("user-unpublished", () => {
        document.getElementById("other-video").innerHTML = "";
    });
</script>
</body>
</html>
