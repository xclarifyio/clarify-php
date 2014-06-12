<?php

namespace OP3Nvoice\Bus;

interface ClientStub
{
    public function getBundles($limit, $embed, $iterator);
    public function createBundle($name, $media_url, $audio_channel, $metadata, $notify_url);
    public function deleteBundle($bundle_id);
    public function getBundle($bundle_id, $embed);
    public function updateBundle($bundle_id, $name, $notify_url, $version);
    public function getBundleMetadata($bundle_id);
    public function updateBundleMetadata($bundle_id, $data, $version);
    public function deleteBundleMetadata($bundle_id);
    public function addBundleTrack($bundle_id, $label, $media_url, $audio_channel, $source);
    public function updateBundleTrack($bundle_id, $track, $label, $media_url, $audio_channel, $source, $version);
    public function getBundleTrack($bundle_id);
    public function deleteBundleTrack($bundle_id, $track);
    public function search($query, $query_fields, $filter, $embed, $iterator);
}
