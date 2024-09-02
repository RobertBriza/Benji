<?php declare(strict_types=1);

namespace Sniffs;

use SlevomatCodingStandard\Helpers\StringHelper;

class FilepathNamespaceExtractor
{
	/** @var string[] */
	private $extensions;
	/** @var string[] */
	private $rootNamespaces;
	/** @var bool[] dir(string) => true(bool) */
	private $skipDirs;

	/**
	 * @param string[] $rootNamespaces directory(string) => namespace
	 * @param string[] $skipDirs
	 * @param string[] $extensions index(integer) => extension
	 */
	public function __construct(array $rootNamespaces, array $skipDirs, array $extensions)
	{
		$this->rootNamespaces = $rootNamespaces;
		$this->skipDirs = array_fill_keys($skipDirs, true);
		$this->extensions = array_map(static function (string $extension): string {
			return strtolower($extension);
		}, $extensions);
	}

	public function getTypeNameFromProjectPath(string $path): ?string
	{
		$extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
		if (! in_array($extension, $this->extensions, true)) {
			return null;
		}

		/** @var string[] $pathParts */
		$pathParts = preg_split('~[/\\\]~', $path);
		$rootNamespace = null;
		while (count($pathParts) > 0) {
			foreach ($this->rootNamespaces as $directory => $namespace) {
				if (! StringHelper::startsWith(implode('/', $pathParts) . '/', $directory . '/')) {
					continue;
				}

				$directoryPartsCount = count(explode('/', $directory));
				for ($i = 0; $i < $directoryPartsCount; $i++) {
					array_shift($pathParts);
				}

				$rootNamespace = $namespace;
				break 2;
			}

			array_shift($pathParts);
		}

		if ($rootNamespace === null) {
			return null;
		}

		array_unshift($pathParts, $rootNamespace);

		$typeName = implode('\\', array_filter($pathParts, function (string $pathPart): bool {
			return ! isset($this->skipDirs[$pathPart]);
		}));

		return substr($typeName, 0, -strlen('.' . $extension));
	}
}
