<?php

class RepositoryTest extends BaseTestCase
{
    /*
    public function it_can_get_list_of_repositories()
    {
        $response = $this->call('GET', '/control-panel/api/repository');
        $this->assertJson($response, []);
    }
    */

    /** @test */
    public function it_can_create_repository()
    {
        $repositoryUrl = 'https://github.com/realshadow/satis-control-panel.git';

        $this->createRepository($repositoryUrl, 'vcs');
        $response = $this->getRepository($repositoryUrl);

        $repositoryData = [
            'type' => 'vcs',
            'url' => $repositoryUrl,
        ];
        $correctJson = json_encode($repositoryData);

        $this->assertJsonStringEqualsJsonString($correctJson, $response);
    }

    private function createRepository($url, $type = 'vcs')
    {
        $repositoryData = [
            'type' => $type,
            'url' => $url,
        ];

        $endpoint = 'control-panel/api/repository';
        $response = $this->call('POST', $endpoint, $repositoryData);

        return $response;
    }

    private function getRepository($url)
    {
        $id = md5($url);
        $endpoint = 'control-panel/api/repository/%s';
        $endpoint = sprintf($endpoint, $id);
        $response = $this->call('GET', $endpoint);

        return $response;
    }
}
