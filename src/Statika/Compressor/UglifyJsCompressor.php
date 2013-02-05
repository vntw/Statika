<?php

/*
 * This file is part of Statika.
 *
 * (c) Sven Scheffler <schefflor@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Statika\Compressor;

use Statika\File\File;
use Statika\Version\Version;
use Buzz\Message\Request;
use Buzz\Message\Response;
use Buzz\Client\FileGetContents;

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
class UglifyJsCompressor extends WebserviceCompressor
{
    /**
     * CTOR
     */
    public function __construct()
    {
        $this->key = 'uglifyjs';
        $this->name = 'UglifyJS JavaScript Minifier';
    }

    /**
     *
     * @param  \Statika\Version\Version  $version
     * @return null
     * @throws \InvalidArgumentException
     */
    public function compress(Version $version)
    {
        $fileSetAggregate = $this->aggregator->aggregate($this->manager->getOutput());

        $this->manager->getOutput()->writeln(
                sprintf('<item>- Compressing file: %s</item>', $version->getFormattedFileName())
        );

        $request = new Request(Request::METHOD_POST, $this->serviceUrl);
        $request->setHeaders(array(
            'Content-Type' => 'application/x-www-form-urlencoded'
        ));
        $request->setContent('js_code=' . urlencode($fileSetAggregate));

        $response = new Response();
        $client = new FileGetContents();
        $client->send($request, $response);

        if ($response->isOk()) {
            $outputPath = $this->buildOutputPath();
            $minifiedCode = $response->getContent();
            $targetMinFile = $outputPath . DIRECTORY_SEPARATOR . $version->getFormattedFileName();

            $this->filesystem->mkdir($outputPath);

            if (false !== file_put_contents($targetMinFile, $minifiedCode)) {
                $outputMinFile = new File($targetMinFile);

                $this->bytesBefore = mb_strlen($fileSetAggregate, 'utf-8');
                $this->bytesAfter = $outputMinFile->getSize();

                return;
            }
        }

        throw new \ErrorException('Error while compressing the fileset');
    }

}
