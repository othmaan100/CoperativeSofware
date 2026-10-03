<?php

namespace Tests\Unit;

use Livewire\Component;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Symfony\Component\Finder\Finder;

/**
 * Livewire's JS `$wire` proxy resolves a name as EITHER a data property OR a
 * callable action, never both — if a component declares a public property
 * and a public method with the same name (e.g. `public string $reply` and
 * `public function reply()`), `$wire.reply` in the browser resolves to the
 * property's value, and `wire:submit="reply"` / `wire:click="reply"` calls
 * that value as a function, which silently does nothing in the browser.
 *
 * `Livewire::test()` in PHPUnit calls methods directly via PHP reflection
 * and never goes through this JS proxy, so this exact bug class passes
 * every existing feature test while being completely broken for a real
 * user — this test is the only thing standing between that happening again.
 */
class LivewirePropertyMethodCollisionTest extends TestCase
{
    public function test_no_livewire_component_has_a_property_and_method_with_the_same_name(): void
    {
        $componentsDir = realpath(__DIR__.'/../../app/Livewire');
        $finder = (new Finder)->files()->name('*.php')->in($componentsDir);

        $violations = [];

        foreach ($finder as $file) {
            $class = $this->classNameFromFile($file->getRealPath());

            if (! $class || ! class_exists($class)) {
                continue;
            }

            $reflection = new ReflectionClass($class);

            if (! $reflection->isSubclassOf(Component::class) || $reflection->isAbstract()) {
                continue;
            }

            $propertyNames = array_map(
                fn ($p) => $p->getName(),
                $reflection->getProperties(\ReflectionProperty::IS_PUBLIC)
            );

            $methodNames = array_map(
                fn ($m) => $m->getName(),
                $reflection->getMethods(\ReflectionMethod::IS_PUBLIC)
            );

            $collisions = array_intersect($propertyNames, $methodNames);

            if (! empty($collisions)) {
                $violations[] = "{$class}: ".implode(', ', $collisions);
            }
        }

        $this->assertEmpty($violations, "The following Livewire components have a public property and a public method sharing a name — this breaks wire:click/wire:submit in a real browser even though Livewire::test() won't catch it:\n".implode("\n", $violations));
    }

    protected function classNameFromFile(string $path): ?string
    {
        $appDir = realpath(__DIR__.'/../../app');
        $relative = str_replace($appDir.DIRECTORY_SEPARATOR, '', $path);
        $relative = str_replace('.php', '', $relative);
        $relative = str_replace(DIRECTORY_SEPARATOR, '\\', $relative);

        return 'App\\'.$relative;
    }
}
