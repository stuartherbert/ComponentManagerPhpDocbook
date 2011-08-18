<?php

/**
 * Copyright (c) 2011 Stuart Herbert.
 * Copyright (c) 2010 Gradwell dot com Ltd.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of the
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package     Phix_Project
 * @subpackage  ComponentManager
 * @author      Stuart Herbert <stuart@stuartherbert.com>
 * @copyright   2011 Stuart Herbert. www.stuartherbert.com
 * @copyright   2010 Gradwell dot com Ltd. www.gradwell.com
 * @license     http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link        http://www.phix-project.org
 * @version     @@PACKAGE_VERSION@@
 */

namespace Phix_Project\ComponentManager\Entities;

class DocbookComponentFolder extends ComponentFolder
{
        const COMPONENT_TYPE = 'php-docbook';
        const LATEST_VERSION = 2;
        const DATA_FOLDER = '@@DATA_DIR@@/ComponentManagerPhpDocbook/php-docbook';
        const DOCBOOK_FOLDER = '@@DATA_DIR@@/DocbookTools/docbook-xsl-1.76.1';
        const FOP_FOLDER = '@@DATA_DIR@@/FopTools/fop-1.0';

        public function createComponent()
        {
                // step 1: create the folders required
                $this->createFolders();

                // step 2: create the build file
                $this->createBuildFile();
                $this->createBuildProperties();

                // step 3: add in the doc files
                $this->createDocFiles();

                // step 4: add in config files for popular source
                // control systems
                $this->createScmIgnoreFiles();

                // step 5: copy in the tools folder
                $this->createTools();

                // if we get here, job done
        }

        protected function createFolders()
        {
                $foldersToMake = array
                (
                        'src',
                        'src/1.0-en',
                        'src/1.0-en/figures',
                        'tools',
                );

                foreach ($foldersToMake as $folderToMake)
                {
                        $folder = $this->folder . '/' . $folderToMake;

                        // does the folder already exist?
                        if (is_dir($folder))
                        {
                                // yes it does ... nothing needed
                                continue;
                        }

                        // no it does not ... create it
                        if (!mkdir ($folder))
                        {
                                // it all went wrong
                                throw new \Exception('unable to create folder ' . $this->folder . '/' . $folderToMake);
                        }
                }
        }

        protected function createBuildFile()
        {
                $this->copyFilesFromDataFolder(array('build.xml', 'build.local.xml'));
        }

        protected function createBuildProperties()
        {
                $this->copyFilesFromDataFolder(array('build.properties'));
        }

        protected function createPackageXmlFile()
        {
                $this->copyFilesFromDataFolder(array('package.xml'));
        }

        protected function createDocFiles()
        {
                $this->copyFilesFromDataFolder(array('README.md', 'LICENSE.txt'));
        }

        protected function createScmIgnoreFiles()
        {
                $this->copyFilesFromDataFolder(array('.gitignore', '.hgignore'));
        }

        protected function createTools()
        {
                $this->replaceFolderContentsFromDataFolder('tools', 'tools');
                $this->enableExecutionOf('tools/scripts/webify.php');
                $this->enableExecutionOf('tools/scripts/highlight.php');
                $this->enableExecutionOf('tools/scripts/HighlightPDF.php');
	}

	/**
	 * Upgrade a php-docbook project to v2
	 *
	 * The changes between v1 and v2 are:
	 *
	 * * support for build.local.xml
	 * * use the separately-packaged docbook tools
	 * * use the separately-packaged fop tools
	 */

	protected function upgradeFrom1To2()
	{
		$this->createBuildFile();

		$this->setBuildProperty('tools.docbook', 'docbook-xsl-1.76.1');
		$this->setBuildProperty('tools.fop', 'fop-1.0');
		$this->recursiveRmdir($this->folder . '/tools/docbook-xsl');
		$this->recursiveRmdir($this->folder . '/tools/fop');
                
                $this->createScmIgnoreFiles();
                
                // $this->copyFolders(self::DOCBOOK_FOLDER, '/tools/docbook-xsl');
                // $this->copyFolders(self::FOP_FOLDER, '/tools/fop');
                // $this->enableExecutionOf('tools/fop/fop');
                // $this->enableExecutionOf('tools/docbook-xsl/epub/bin/dbtoepub');
	}
}
